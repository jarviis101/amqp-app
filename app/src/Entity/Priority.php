<?php

namespace App\Entity;

class Priority
{
    public const MIN_VALUE = 1;
    public const MAX_VALUE = 5;

    private int $level;

    public function __construct(int $level = self::MIN_VALUE)
    {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function equals(Priority $priority): bool
    {
        return $this->level === $priority->getLevel();
    }
}
