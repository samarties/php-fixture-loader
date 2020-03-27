<?php

declare(strict_types=1);

namespace Test\Value\Table\TableReferenceHeader;

use App\Value\Table\TableReferenceHeader;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Value\Table\TableReferenceHeader
 * @small
 */
final class ErrorsWhenInvalidStringTest extends TestCase
{
    /**
     * @param string $givenString
     * @dataProvider dataProvider
     */
    public function test(string $givenString): void
    {
        $expectedException = new InvalidArgumentException(
            sprintf(
                'Expected a value equal to "%s". Got: "%s"',
                TableReferenceHeader::REFERENCE_HEADER_VALUE,
                $givenString
            )
        );
        $this->expectExceptionObject($expectedException);

        TableReferenceHeader::fromString($givenString);
    }

    public function dataProvider(): array
    {
        return [
            'blank' => [
                'givenString' => '',
            ],
            'invalid' => [
                'givenString' => '(invalid)',
            ],
            'almostCorrect' => [
                'givenString' => TableReferenceHeader::REFERENCE_HEADER_VALUE . '!',
            ],
        ];
    }
}
