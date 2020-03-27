<?php

declare(strict_types=1);

namespace App\Sample;

use App\Transformer\Row\RowTransformer;
use App\Value\Fixture\Fixture;

final class PersonTransformer implements RowTransformer
{
    public function transform(array $row): Person
    {
        /** @var Fixture|null $parent */
        $parent = $row['parent'];

        $person = new Person();
        $person->id = uniqid();
        $person->forename = $row['forename'];
        $person->surname = $row['surname'];
        $person->frozen = $row['frozen'];
        $person->parent = $parent ? $parent->entity() : null;

        return $person;
    }
}
