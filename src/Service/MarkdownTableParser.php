<?php

declare(strict_types=1);

namespace App\Service;

use App\Transformer\Cell\CellTransformer;
use App\Value\Table\Table;
use App\Value\Table\TableCell;
use App\Value\Table\TableHeader;
use App\Value\Table\TableHeaders;
use App\Value\Table\TableRow;
use Closure;
use Exception;

final class MarkdownTableParser
{
    private CellTransformerRegistry $transformerRegistry;

    public function __construct(CellTransformerRegistry $transformerRegistry)
    {
        $this->transformerRegistry = $transformerRegistry;
    }

    public function parse(string $markdownTable): Table
    {
        $rows = explode(PHP_EOL, trim($markdownTable));
        $explodedRows = array_map(
            Closure::fromCallable([$this, 'explodeRow']),
            $rows
        );

        $parsedHeaderRow = TableHeaders::fromStrings($explodedRows[0]);
        $parsedRows = array_map(
            fn (array $row) => $this->parseRow($parsedHeaderRow, $row),
            array_slice($explodedRows, 2)
        );

        return Table::fromRows($parsedHeaderRow, $parsedRows);
    }

    private function parseRow(TableHeaders $headers, array $row): TableRow
    {
        $parsedCells = array_map(
            fn (string $cell, int $index) => $this->parseCell($headers->atIndex($index), $cell),
            $row,
            array_keys($row)
        );

        return TableRow::fromCells($parsedCells);
    }

    private function parseCell(TableHeader $header, string $cell): TableCell
    {
        $transformer = $this->getTransformer($header->type() ?? 'string');
        $transformedValue = $header->nullable() === true && trim($cell) === ''
            ? null
            : $transformer->transform($cell);

        return TableCell::fromValue($transformedValue);
    }

    private function explodeRow(string $markdownRow): array
    {
        $trimmedRow = trim($markdownRow, '');
        $explodedRow = explode('|', $trimmedRow);

        return array_slice($explodedRow, 1, count($explodedRow) - 2);
    }

    private function getTransformer(string $type): CellTransformer
    {
        if ($this->transformerRegistry->hasTransformer($type) === false) {
            throw new Exception(
                sprintf('No transformer has been registered for type \'%s\'.', $type)
            );
        }

        return $type === null
            ? null
            : $this->transformerRegistry->transformer($type);
    }
}
