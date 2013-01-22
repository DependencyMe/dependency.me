<?php

namespace Hal\Bundle\ReleaseBundle\Service;

use Hal\Bundle\GithubBundle\Entity\Branche;
use Hal\Bundle\ReleaseBundle\Entity\Requirement;

interface RequirementServiceInterface
{
    public function getStateOfBranche(Branche $branche);

    public function getStateOfRequirement(Requirement $requirement);

    public function getStateOf($element);
}
