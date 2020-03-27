<?php

declare(strict_types=1);

namespace Test\Value\Table\TableReferenceHeader;

use App\Value\Table\TableReferenceHeader;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Value\Table\TableReferenceHeader
 * @small
 */
final class BuildFromStringTest extends TestCase
{
    /**
     * @param string $givenString
     * @dataProvider dataProvider
     */
    public function test(string $givenString): void
    {
        $expectedHeader = TableReferenceHeader::build();
        $actualHeader = TableReferenceHeader::fromString($givenString);

        $this->assertEquals($expectedHeader, $actualHeader);
    }

    public function dataProvider(): array
    {
        return [
            'exact' => [
                'givenString' => TableReferenceHeader::REFERENCE_HEADER_VALUE,
            ],
            'leadingSpace' => [
                'givenString' => ' ' . TableReferenceHeader::REFERENCE_HEADER_VALUE,
            ],
            'trailingSpace' => [
                'givenString' => TableReferenceHeader::REFERENCE_HEADER_VALUE . ' ',
            ],
            'leadingAndTrailingSpace' => [
                'givenString' => ' ' . TableReferenceHeader::REFERENCE_HEADER_VALUE . ' ',
            ],
        ];
    }
}
