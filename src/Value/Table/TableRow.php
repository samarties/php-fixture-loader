<?php

declare(strict_types=1);

namespace App\Value\Table;

use Webmozart\Assert\Assert;

final class TableRow
{
    /** @var TableCell[] */
    private array $cells;

    private function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    /**
     * @param TableCell[] $cells
     * @return static
     */
    public static function fromCells(array $cells): self
    {
        Assert::allIsInstanceOf($cells, TableCell::class, 'TableRow must only contain TableCell instances.');

        return new self($cells);
    }

    /**
     * @return TableCell[]
     */
    public function cells(): array
    {
        return $this->cells;
    }

    public function cellAtIndex(int $index): ?TableCell
    {
        return $this->cells[$index] ?? null;
    }
}
