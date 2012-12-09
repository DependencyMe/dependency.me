<?php

namespace Hal\ReleaseBundle\Dbal\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * @link http://docs.doctrine-project.org/en/latest/cookbook/mysql-enums.html
 */
abstract class EnumType extends Type
{

    protected $name;
    protected $values = array();

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(function($val) {
                return "'" . $val . "'";
            }, $this->values);

        return "ENUM(" . implode(", ", $values) . ") COMMENT '(DC2Type:" . $this->name . ")'";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->values)) {
            throw new \InvalidArgumentException("Invalid '" . $this->name . "' value.");
        }
        return $value;
    }

    public function getName()
    {
        return $this->name;
    }

}