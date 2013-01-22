<?php
namespace Hal\Bundle\GithubBundle\Repository;
use Hal\Bundle\GithubBundle\Entity\OwnerInterface;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;

interface RepositoryRepositoryInterface
{


    public function getByOwner(OwnerInterface $auth);

    public function getByName($name);

    public function saveRepository(Repository $repository);

    public function removeByOwner(OwnerInterface $owner);

    public function search($expression);
}