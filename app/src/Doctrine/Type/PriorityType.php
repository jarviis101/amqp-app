<?php

namespace App\Doctrine\Type;

use App\Entity\Priority;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class PriorityType extends IntegerType
{
    public const NAME = 'task_priority';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value instanceof Priority ? $value->getLevel() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Priority
    {
        return !empty($value) ? new Priority($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
}
