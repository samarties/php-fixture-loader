<?php

declare(strict_types=1);

namespace App\Value\Fixture;

use App\Value\Fixture\FixtureReference;
use Webmozart\Assert\Assert;

final class Fixtures
{
    /** @var Fixture[] */
    private array $fixtures;

    /**
     * @param Fixture[] $fixtures
     */
    private function __construct(array $fixtures)
    {
        $this->fixtures = $fixtures;
    }

    /**
     * @param Fixture[] $fixtures
     * @return static
     */
    public static function fromArray(array $fixtures): self
    {
        Assert::allIsInstanceOf($fixtures, Fixture::class);

        return new self($fixtures);
    }

    public function add(Fixture $fixture): self
    {
        return new self([
            ...$this->fixtures,
            $fixture
        ]);
    }

    public function append(Fixtures $fixtures): self
    {
        return new self([
            ...$this->fixtures,
            ...$fixtures->toArray(),
        ]);
    }

    public function fixture(FixtureReference $reference): ?Fixture
    {
        foreach ($this->fixtures as $fixture) {
            if ($fixture->reference() !== null && $fixture->reference()->matches($reference)) {
                return $fixture;
            }
        }

        return null;
    }

    /**
     * @return Fixture[]
     */
    public function toArray(): array
    {
        return $this->fixtures;
    }
}
