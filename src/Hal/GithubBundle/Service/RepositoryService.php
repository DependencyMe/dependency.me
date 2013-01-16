<?php
namespace Hal\GithubBundle\Service;
use Hal\GithubBundle\Repository\RepositoryRepositoryInterface;
use Hal\GithubBundle\Entity\Repository;

class RepositoryService
{
    private $repository;

    function __construct(RepositoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function saveRepository(Repository $repo)
    {
        $this->repository->saveRepository($repo);
    }

}
