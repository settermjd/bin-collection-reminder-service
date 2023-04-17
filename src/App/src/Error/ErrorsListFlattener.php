<?php

declare(strict_types=1);

namespace App\Error;

use function array_values;
use function implode;

class ErrorsListFlattener
{
    private array $output = [];

    public function flattenArray(array $value, string $key): void
    {
        $this->output[$key] = implode('. ', array_values($value));
    }

    public function getFlattenedArray(): array
    {
        return $this->output;
    }
}
