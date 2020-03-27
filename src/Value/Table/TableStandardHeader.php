<?php

declare(strict_types=1);

namespace App\Value\Table;

use Webmozart\Assert\Assert;

final class TableStandardHeader implements TableHeader
{
    private string $title;
    private ?string $type;
    private bool $nullable;

    private function __construct(string $title, ?string $type, bool $nullable)
    {
        $this->title = $title;
        $this->type = $type;
        $this->nullable = $nullable;
    }

    public static function fromArgs(string $title, ?string $type, bool $nullable): self
    {
        $preparedTitle = trim($title);
        $preparedType = $type !== null ? trim($type) : null;

        Assert::stringNotEmpty($preparedTitle);
        Assert::nullOrNotEmpty($preparedType);

        return new self(
            $preparedTitle,
            $preparedType,
            $nullable
        );
    }

    public static function fromString(string $value): self
    {
        list($title, $type) = explode(':', $value);

        $preparedTitle = trim($title);
        $nullable = $type === null || substr(ltrim($type), 0, 1) === '?';
        $preparedType = $type === null ? null : rtrim(ltrim($type, ' ?'));

        return self::fromArgs(
            $preparedTitle,
            $preparedType,
            $nullable
        );
    }

    public function title(): string
    {
        return $this->title;
    }

    public function type(): ?string
    {
        return $this->type;
    }

    public function nullable(): bool
    {
        return $this->nullable;
    }
}
