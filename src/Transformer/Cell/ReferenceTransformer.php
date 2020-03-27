<?php

declare(strict_types=1);

namespace App\Transformer\Cell;

use App\Value\Fixture\FixtureReference;

final class ReferenceTransformer implements CellTransformer
{
    public function transform(string $cell): FixtureReference
    {
        return FixtureReference::fromString($cell);
    }
}
