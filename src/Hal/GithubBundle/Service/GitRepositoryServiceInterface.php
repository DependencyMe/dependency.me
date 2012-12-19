<?php
namespace Hal\GithubBundle\Service;
use Hal\ReleaseBundle\Entity\OwnerInterface;

interface GitRepositoryServiceInterface
{
    public function listRepositories(OwnerInterface $owner);
}