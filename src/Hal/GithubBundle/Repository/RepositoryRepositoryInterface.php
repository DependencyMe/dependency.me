<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\OwnerInterface;
use Hal\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;

interface RepositoryRepositoryInterface
{


    public function getByOwner(OwnerInterface $auth);

    public function getByName($name);

    public function saveRepository(Repository $repository);

    public function removeByOwner(OwnerInterface $owner);
}