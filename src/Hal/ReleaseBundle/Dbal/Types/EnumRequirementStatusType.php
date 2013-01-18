<?php

namespace Hal\ReleaseBundle\Dbal\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Hal\ReleaseBundle\Entity\RequirementInterface;
class EnumRequirementStatusType extends EnumType
{

    const NAME = 'requirementstatus';
    const STATUS_OUT_OF_DATE = RequirementInterface::STATUS_OUT_OF_DATE;
    const STATUS_RECENT = RequirementInterface::STATUS_RECENT;
    const STATUS_LATEST = RequirementInterface::STATUS_LATEST;
    const STATUS_UNKNOWN = RequirementInterface::STATUS_UNKNOWN;

    protected $name = self::NAME;
    protected $values = array(self::STATUS_UNKNOWN, self::STATUS_LATEST, self::STATUS_RECENT, self::STATUS_OUT_OF_DATE);

}
