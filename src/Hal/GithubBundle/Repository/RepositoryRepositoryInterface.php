<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Hal\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;

interface RepositoryRepositoryInterface
{


    public function getByOwner(AuthentifiableInterface $auth);

    public function getByName($name);

    public function saveRepository(Repository $repository);
}