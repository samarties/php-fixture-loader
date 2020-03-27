<?php

declare(strict_types=1);

namespace App\Value\Table;

use Webmozart\Assert\Assert;

final class TableHeaders
{
    /** @var TableHeader[] */
    private array $headers;

    private function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public static function fromHeaders(array $headers): self
    {
        Assert::allIsInstanceOf($headers, TableHeader::class);

        return new self($headers);
    }

    /**
     * @param string[] $strings
     * @return static
     */
    public static function fromStrings(array $strings): self
    {
        $headers = array_map(
            fn (string $string) => trim($string) === TableReferenceHeader::REFERENCE_HEADER_VALUE
                ? TableReferenceHeader::fromString($string)
                : TableStandardHeader::fromString($string),
            $strings
        );

        $referenceHeadersCount = array_reduce(
            $headers,
            fn (int $count, TableHeader $header): int => $count + ($header instanceof TableReferenceHeader ? 1 : 0),
            0
        );

        Assert::lessThanEq($referenceHeadersCount, 1);

        return new self($headers);
    }

    public function atIndex(int $index): ?TableHeader
    {
        return $this->headers[$index] ?? null;
    }

    public function referenceHeaderIndex(): ?int
    {
        foreach ($this->headers as $index => $header) {
            if ($header instanceof TableReferenceHeader) {
                return $index;
            }
        }

        return null;
    }
}
