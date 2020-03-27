<?php

declare(strict_types=1);

namespace App\Transformer\Cell;

final class StringTransformer implements CellTransformer
{
    public function transform(string $cell): string
    {
        return trim($cell);
    }
}
