<?php

declare(strict_types=1);

namespace App\Transformer\Cell;

final class IntegerTransformer implements CellTransformer
{
    public function transform(string $cell): int
    {
        return (int) $cell;
    }
}
