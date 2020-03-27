<?php

declare(strict_types=1);

namespace App\Transformer\Row;

final class ArrayTransformer implements RowTransformer
{
    public function transform(array $row): array
    {
        return $row;
    }
}
