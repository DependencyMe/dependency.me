<?php

namespace Hal\Bundle\GithubBundle\Service;

use Hal\Bundle\GithubBundle\Entity\Branche;

interface BrancheServiceInterface
{

    public function getByFullName($name);

    public function saveBranche(Branche $branche);
}
