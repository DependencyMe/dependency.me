<?php
namespace Hal\Bundle\GithubBundle\Service;
use Hal\Bundle\GithubBundle\Repository\RepositoryRepositoryInterface;
use Hal\Bundle\GithubBundle\Entity\Repository;

class RepositoryService
{
    private $repository;
    private $options;

    function __construct(RepositoryRepositoryInterface $repository, array $options)
    {
        $this->repository = $repository;
        $this->options = $options;
    }

    public function saveRepository(Repository $repo)
    {
        $this->repository->saveRepository($repo);
    }

    public function search($expression)
    {
        return $this->repository->search($expression);
    }

    public function listRecentlyUpdated()
    {
        return $this->repository->listRecentlyUpdated($this->options['display']['recents']['repository']);
    }
}
