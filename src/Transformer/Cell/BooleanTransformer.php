<?php

declare(strict_types=1);

namespace App\Transformer\Cell;

final class BooleanTransformer implements CellTransformer
{
    public function transform(string $cell): bool
    {
        return !!trim($cell);
    }
}
