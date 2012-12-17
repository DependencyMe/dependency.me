<?php

namespace Hal\ReleaseBundle\Dbal\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EnumRequirementStatusType extends EnumType
{

    const NAME = 'requirementstatus';
    const STATUS_OUT_OF_DATE = 'outofdate';
    const STATUS_RECENT = 'recent';
    const STATUS_LATEST = 'latest';

    protected $name = self::NAME;
    protected $values = array(self::STATUS_LATEST, self::STATUS_RECENT, self::STATUS_OUT_OF_DATE);

}
