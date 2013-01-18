<?php

namespace Hal\ReleaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requirement
 */
interface RequirementInterface
{

    const STATUS_OUT_OF_DATE = 'outofdate';
    const STATUS_RECENT = 'recent';
    const STATUS_LATEST = 'latest';
    const STATUS_UNKNOWN = 'unknown';

}