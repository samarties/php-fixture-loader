<?php

declare(strict_types=1);

namespace App\Transformer\Row;

interface RowTransformer
{
    public function transform(array $row);
}
