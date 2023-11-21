<?php

namespace App\Traits\Enums;

trait WithConditionals
{
    public function is(self $case): bool
    {
        return $this === $case;
    }

    public function isNot(self $case): bool
    {
        return $this !== $case;
    }

    public function in(self ...$cases): bool
    {
        return in_array($this, $cases);
    }

    public function notIn(self ...$cases): bool
    {
        return ! $this->in(...$cases);
    }
}
