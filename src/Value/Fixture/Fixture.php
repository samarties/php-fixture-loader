<?php

declare(strict_types=1);

namespace App\Value\Fixture;

final class Fixture
{
    private ?FixtureReference $reference;

    /** @var mixed */
    private $entity;

    private function __construct(?FixtureReference $reference, $entity)
    {
        $this->reference = $reference;
        $this->entity = $entity;
    }

    public static function fromEntity(?FixtureReference $reference, $entity): self
    {
        return new self($reference, $entity);
    }

    public function reference(): ?FixtureReference
    {
        return $this->reference;
    }

    public function entity()
    {
        return $this->entity;
    }
}
