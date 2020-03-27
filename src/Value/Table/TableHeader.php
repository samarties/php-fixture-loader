<?php

declare(strict_types=1);

namespace App\Value\Table;

interface TableHeader
{
    public static function fromString(string $value): self;

    public function title(): string;

    public function type(): ?string;

    public function nullable(): bool;
}
