<?php

declare(strict_types=1);

namespace App\Service;

use App\Transformer\Row\RowTransformer;
use App\Value\BuildableTable;
use App\Value\Fixture\Fixture;
use App\Value\Fixture\FixtureReference;
use App\Value\Fixture\Fixtures;
use App\Value\Table\TableCell;
use App\Value\Table\TableHeaders;
use App\Value\Table\TableReferenceHeader;
use App\Value\Table\TableRow;
use Closure;
use Webmozart\Assert\Assert;

final class FixtureBuilder
{
    public function buildTables(array $buildableTables): Fixtures
    {
        Assert::allIsInstanceOf($buildableTables, BuildableTable::class);

        return array_reduce(
            $buildableTables,
            Closure::fromCallable([$this, 'buildTable']),
            Fixtures::fromArray([])
        );
    }

    private function buildTable(Fixtures $previousFixtures, BuildableTable $buildableTable): Fixtures
    {
        $table = $buildableTable->table();
        foreach ($table->rows() as $row) {
            $fixture = $this->buildRow(
                $table->headers(),
                $row,
                $buildableTable->rowTransformer(),
                $previousFixtures
            );
            $previousFixtures = $previousFixtures->add($fixture);
        }

        return $previousFixtures;
    }

    private function buildRow(
        TableHeaders $headers,
        TableRow $row,
        RowTransformer $rowTransformer,
        Fixtures $previousFixtures
    ): Fixture {
        $preparedRow = $this->prepareRow($headers, $row, $previousFixtures);
        $reference = $this->determineRowReference($preparedRow);

        return Fixture::fromEntity(
            $reference,
            $rowTransformer->transform($preparedRow)
        );
    }

    private function prepareRow(
        TableHeaders $headers,
        TableRow $row,
        Fixtures $previousFixtures
    ): array {
        $rowWithLinkedReferences = $this->replaceReferencesInRow($headers, $row, $previousFixtures);

        return $this->transformRowToAssocArray($headers, $rowWithLinkedReferences);
    }

    private function determineRowReference(array $preparedRow): ?FixtureReference
    {
        return $preparedRow[TableReferenceHeader::REFERENCE_HEADER_VALUE] ?? null;
    }

    private function replaceReferencesInRow(
        TableHeaders $headers,
        TableRow $row,
        Fixtures $previousFixtures
    ): TableRow {
        $referenceHeaderIndex = $headers->referenceHeaderIndex();
        $processedCells = [];
        foreach ($row->cells() as $cellIndex => $cell) {
            $processedCells[] = (
                $cellIndex !== $referenceHeaderIndex
                && $cell->value() instanceof FixtureReference
            )
                ? TableCell::fromValue($this->requireFixture($previousFixtures, $cell->value()))
                : $cell;
        }

        return TableRow::fromCells($processedCells);
    }

    private function requireFixture(Fixtures $fixtures, FixtureReference $reference): Fixture
    {
        $fixture = $fixtures->fixture($reference);

        Assert::notNull(
            $fixture,
            sprintf('Could not find fixture with reference \'%s\'.', $reference->toString())
        );

        return $fixture;
    }

    private function transformRowToAssocArray(TableHeaders $headers, TableRow $row): array
    {
        return array_reduce(
            array_keys($row->cells()),
            fn (array $entity, int $index) => array_merge(
                $entity,
                [$headers->atIndex($index)->title() => $row->cellAtIndex($index)->value()]
            ),
            []
        );
    }
}
