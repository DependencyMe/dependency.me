<?php

namespace Hal\Bundle\ReleaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requirement
 */
interface RequirementInterface
{

    const STATUS_OUT_OF_DATE = 'outofdate';
    const STATUS_RECENT = 'recent';
    const STATUS_LATEST = 'latest';
    const STATUS_DEV = 'dev'; // alpha, beta...
    const STATUS_UNKNOWN = 'unknown';

}