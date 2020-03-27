<?php

declare(strict_types=1);

namespace Test\Value\Table\TableStandardHeader;

use App\Value\Table\TableStandardHeader;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Value\Table\TableStandardHeader
 * @small
 */
final class BuildFromStringTest extends TestCase
{
    /**
     * @param string $givenString
     * @param TableStandardHeader $expectedHeader
     * @dataProvider dataProvider
     */
    public function test(string $givenString, TableStandardHeader $expectedHeader): void
    {
        $actualHeader = TableStandardHeader::fromString($givenString);

        $this->assertEquals($expectedHeader, $actualHeader);
    }

    public function dataProvider(): array
    {
        return [
            'titleOnly' => [
                'givenString' => 'column1',
                'expectedHeader' => TableStandardHeader::fromArgs('column1', null, true),
            ],
            'titleWithSpacesOnly' => [
                'givenString' => 'column one',
                'expectedHeader' => TableStandardHeader::fromArgs('column one', null, true),
            ],
            'titleAndType' => [
                'givenString' => 'column1: bool',
                'expectedHeader' => TableStandardHeader::fromArgs('column1', 'bool', false),
            ],
            'titleWithSpacesAndType' => [
                'givenString' => 'column one: bool',
                'expectedHeader' => TableStandardHeader::fromArgs('column one', 'bool', false),
            ],
            'titleAndNullableType' => [
                'givenString' => 'column1: ?bool',
                'expectedHeader' => TableStandardHeader::fromArgs('column1', 'bool', true),
            ],
            'titleWithSpacesAndNullableType' => [
                'givenString' => 'column one: ?bool',
                'expectedHeader' => TableStandardHeader::fromArgs('column one', 'bool', true),
            ],
        ];
    }
}
