<?php

namespace Hal\ReleaseBundle\Dbal\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Hal\ReleaseBundle\Release\Version\ReleaseInterface;
use Hal\ReleaseBundle\Release\Version\Release;

class ReleaseType extends Type
{

    const NAME = 'version';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "VARCHAR(30)";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Release($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof ReleaseInterface) {
            throw new \InvalidArgumentException("Invalid release given, we cannot convert it to database");
        }
        return $value->getPrettyString();
    }

    public function getName()
    {
        return self::NAME;
    }

}