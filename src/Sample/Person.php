<?php

declare(strict_types=1);

namespace App\Sample;

final class Person
{
    public string $id;
    public ?string $forename;
    public ?string $surname;
    public bool $frozen;
    public ?Person $parent;
}
