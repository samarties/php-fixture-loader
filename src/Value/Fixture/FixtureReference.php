<?php

declare(strict_types=1);

namespace App\Value\Fixture;

use Webmozart\Assert\Assert;

final class FixtureReference
{
    private string $reference;

    private function __construct(string $reference)
    {
        $this->reference = $reference;
    }

    public static function fromString(string $reference): self
    {
        $preparedReference = trim($reference);

        Assert::stringNotEmpty($preparedReference, 'FixtureReference must not be an empty string.');

        return new self($preparedReference);
    }

    public function matches(FixtureReference $reference): bool
    {
        return $this->reference === $reference->toString();
    }

    public function toString(): string
    {
        return $this->reference;
    }
}
