<?php

declare(strict_types=1);

namespace Test\Value\Table\TableHeaders;

use App\Value\Table\TableHeaders;
use App\Value\Table\TableReferenceHeader;
use App\Value\Table\TableStandardHeader;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Value\Table\TableHeaders
 * @small
 */
final class BuildFromStringsTest extends TestCase
{
    public function test(): void
    {
        $givenStrings = [
            'column1: string',
            'column2: customType',
            'column3: ?bool',
            TableReferenceHeader::REFERENCE_HEADER_VALUE,
            'column5',
        ];

        $expectedHeaders = TableHeaders::fromHeaders([
            TableStandardHeader::fromArgs('column1', 'string', false),
            TableStandardHeader::fromArgs('column2', 'customType', false),
            TableStandardHeader::fromArgs('column3', 'bool', true),
            TableReferenceHeader::build(),
            TableStandardHeader::fromArgs('column5', null, true),
        ]);

        $actualHeaders = TableHeaders::fromStrings($givenStrings);

        $this->assertEquals($expectedHeaders, $actualHeaders);
    }
}
