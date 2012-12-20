<?php

namespace Hal\ReleaseBundle\Dbal\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Hal\ReleaseBundle\Release\Version\ConstraintInterface;
use Hal\ReleaseBundle\Factory\ConstraintFactory;
class ConstraintType extends Type
{

    const NAME = 'constraint';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'VARCHAR(60)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $factory = new ConstraintFactory();
        return $factory->factory($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof ConstraintInterface) {
            throw new \InvalidArgumentException("Invalid constraint given, we cannot convert it to database");
        }
        return $value->getPrettyString();
    }

    public function getName()
    {
        return self::NAME;
    }

}