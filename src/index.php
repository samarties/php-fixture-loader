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

$parsedPersonTable = $markdownTableParser->parse($markdownPersonTable);
$parsedCatTable = $markdownTableParser->parse($markdownCatTable);

$fixtureBuilder = new FixtureBuilder();
$fixtures = $fixtureBuilder->buildTables([
    BuildableTable::usingTransformer($parsedPersonTable, new PersonTransformer()),
    BuildableTable::usingTransformer($parsedCatTable, new ArrayTransformer()),
]);
die();
