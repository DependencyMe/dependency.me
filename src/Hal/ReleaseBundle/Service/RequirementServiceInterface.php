<?php

namespace Hal\ReleaseBundle\Service;

use Hal\GithubBundle\Entity\Branche;
use Hal\ReleaseBundle\Entity\Requirement;

interface RequirementServiceInterface
{
    public function getStateOfBranche(Branche $branche);

    public function getStateOfRequirement(Requirement $requirement);

    public function getStateOf($element);
}
