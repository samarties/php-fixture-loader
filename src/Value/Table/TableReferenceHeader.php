<?php

declare(strict_types=1);

namespace App\Value\Table;

use Webmozart\Assert\Assert;

final class TableReferenceHeader implements TableHeader
{
    public const REFERENCE_HEADER_VALUE = '(ref)';

    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public static function fromString(string $value): self
    {
        $preparedValue = trim($value);

        Assert::eq($preparedValue, self::REFERENCE_HEADER_VALUE);

        return new self();
    }

    public function title(): string
    {
        return self::REFERENCE_HEADER_VALUE;
    }

    public function type(): ?string
    {
        return 'ref';
    }

    public function nullable(): bool
    {
        return true;
    }
}
