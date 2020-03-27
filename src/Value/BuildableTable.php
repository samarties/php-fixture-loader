<?php

declare(strict_types=1);

namespace App\Value;

use App\Transformer\Row\RowTransformer;
use App\Value\Table\Table;

final class BuildableTable
{
    private Table $table;
    private RowTransformer $rowTransformer;

    private function __construct(Table $table, RowTransformer $rowTransformer)
    {
        $this->table = $table;
        $this->rowTransformer = $rowTransformer;
    }

    public static function usingTransformer(Table $table, RowTransformer $rowTransformer): self
    {
        return new self($table, $rowTransformer);
    }

    public function table(): Table
    {
        return $this->table;
    }

    public function rowTransformer(): RowTransformer
    {
        return $this->rowTransformer;
    }
}
