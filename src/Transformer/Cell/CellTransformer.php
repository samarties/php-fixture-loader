<?php

declare(strict_types=1);

namespace App\Transformer\Cell;

interface CellTransformer
{
    public function transform(string $cell);
}
