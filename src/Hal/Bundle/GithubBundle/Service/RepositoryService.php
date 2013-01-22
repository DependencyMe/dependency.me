<?php
namespace Hal\Bundle\GithubBundle\Service;
use Hal\Bundle\GithubBundle\Repository\RepositoryRepositoryInterface;
use Hal\Bundle\GithubBundle\Entity\Repository;

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

    public function search($expression)
    {
        return $this->repository->search($expression);
    }

}
