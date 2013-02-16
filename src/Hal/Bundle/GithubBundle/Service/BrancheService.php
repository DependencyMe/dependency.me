<?php

namespace Hal\Bundle\GithubBundle\Service;

use Hal\Bundle\GithubBundle\Repository\BrancheRepositoryInterface;
use Hal\Bundle\GithubBundle\Entity\Branche;

class BrancheService implements BrancheServiceInterface
{

    private $repository;

    function __construct(BrancheRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByFullName($name)
    {
        return $this->repository->getByFullName($name);
    }

    public function saveBranche(Branche $branche)
    {
        return $this->repository->saveBranche($branche);
    }

}
