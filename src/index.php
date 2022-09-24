<?php

use App\Sample\PersonTransformer;
use App\Service\CellTransformerRegistry;
use App\Service\FixtureBuilder;
use App\Service\MarkdownTableParser;
use App\Transformer\Cell\BooleanTransformer;
use App\Transformer\Cell\IntegerTransformer;
use App\Transformer\Cell\ReferenceTransformer;
use App\Transformer\Cell\StringTransformer;
use App\Transformer\Row\ArrayTransformer;
use App\Value\BuildableTable;

require 'vendor/autoload.php';

$markdownTableParser = new MarkdownTableParser(
    new CellTransformerRegistry([
        'string' => new StringTransformer(),
        'int' => new IntegerTransformer(),
        'bool' => new BooleanTransformer(),
        'ref' => new ReferenceTransformer(),
    ])
);

$markdownPersonTable = '
        | (ref) | forename: string | surname         | frozen: bool | parent: ?ref |
        |-------|------------------|-----------------|--------------|--------------|
        |       | Roger            |                 | 0            |              |
        | tom   | Tom              | Moore           | 1            |              |
        |       |                  | Jones           | 0            | tom          |
        | alex  | Alex             | Candy           | 0            | tom          |
    ';

$markdownCatTable = '
        | owner: ref | (ref)     | name: string  | age: int |
        |------------|-----------|---------------|----------|
        | alex       | fluffy    | Fluffy        | 5        |
        | tom        | sprinkles | Mr. Sprinkles | 11       |
    ';

$markdownCatTable2 = '
        | owner: ref   | (ref)           | name: random      | age: int | (repeat) | (copy) |
        |--------------|-----------------|-------------------|----------|----------|--------|
        | alex         | fluffy          | Fluffy #{3..5}    | 5        | 1        |        |
        | tom          | ${copy}${index} | Mr. Sprinkles     | 11       | 3        | fluffy |
        | tom${repeat} | sprinkles       | ${index}          | 11       | #{4..10} |        |
        | alex         |                 | !{fn1(!{fn2(3)})} | 3        | 0        |        |
    ';

$parsedPersonTable = $markdownTableParser->parse($markdownPersonTable);
$parsedCatTable = $markdownTableParser->parse($markdownCatTable);

$fixtureBuilder = new FixtureBuilder();
$fixtures = $fixtureBuilder->buildTables([
    BuildableTable::usingTransformer($parsedPersonTable, new PersonTransformer()),
    BuildableTable::usingTransformer($parsedCatTable, new ArrayTransformer()),
]);
die();



$markdownUsersTable = '
        | (ref) | forename: string |
        |-------|------------------|
        |       | Roger            |
        | tom   | Tom              |
        |       |                  |
        | alex  | Alex             |
    ';

$markdownBroadcastsTable = '
        | (ref) | name: string     | created_at: date    | sent_at: date       | created_by: ref | stack_id: uuid                       |
        |-------|------------------|---------------------|---------------------|-----------------|--------------------------------------|
        | one   | broadcast one    | 2018-01-17T09:00:00 | 2018-01-17T09:00:00 | tom             | cfd27f2d-c347-446f-9f51-339e2a4e4a89 |
        | two   | broadcast two    | 2018-01-17T09:00:00 |                     | alex            | 2e0aca8b-2cd7-4e2c-a678-f44bb31bcb29 |
    ';

$markdownRecipientsTable = '
        | (ref) | user: ref | broadcast: ref | affected_offset: int |
        |-------|-----------|----------------|----------------------|
        |       | tom       | two            | 0                    |
        | tom   | alex      | two            | 300                  |
    ';

$markdownCardsTable = '
        | (ref) | broadcast: ref | text  |
        |-------|----------------|-------|
        |       | two            | hello |
        |       | one            | world |
    ';