<?php

declare(strict_types=1);

namespace App\Value\Table;

final class TableCell
{
    /** @var mixed */
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function fromValue($value): self
    {
        return new self($value);
    }

    public function value()
    {
        return $this->value;
    }
}
