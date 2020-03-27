<?php

declare(strict_types=1);

namespace App\Value\Table;

use Webmozart\Assert\Assert;

final class Table
{
    private TableHeaders $headers;

    /** @var TableRow[] */
    private array $rows;

    private function __construct(TableHeaders $headers, array $rows)
    {
        $this->headers = $headers;
        $this->rows = $rows;
    }

    /**
     * @param TableHeaders $headers
     * @param TableRow[] $rows
     * @return static
     */
    public static function fromRows(TableHeaders $headers, array $rows): self
    {
        Assert::allIsInstanceOf($rows, TableRow::class);

        return new self($headers, $rows);
    }

    public function headers(): TableHeaders
    {
        return $this->headers;
    }

    /**
     * @return TableRow[]
     */
    public function rows(): array
    {
        return $this->rows;
    }
}
