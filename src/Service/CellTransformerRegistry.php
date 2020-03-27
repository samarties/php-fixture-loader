<?php

declare(strict_types=1);

namespace App\Service;

use App\Transformer\Cell\CellTransformer;

final class CellTransformerRegistry
{
    /** @var CellTransformer[] */
    private array $transformers;

    /**
     * @param CellTransformer[] $transformers
     */
    public function __construct(array $transformers)
    {
        $this->transformers = $transformers;
    }

    public function hasTransformer(string $type): bool
    {
        return isset($this->transformers[$type]);
    }

    public function transformer(string $type): ?CellTransformer
    {
        return $this->transformers[$type] ?? null;
    }
}
