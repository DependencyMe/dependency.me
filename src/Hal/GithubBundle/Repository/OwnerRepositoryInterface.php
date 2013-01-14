<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

interface OwnerRepositoryInterface
{
    public function findOwnerByAuth(AuthentifiableInterface $auth);
}