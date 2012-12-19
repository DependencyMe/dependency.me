<?php
namespace Hal\ReleaseBundle\Repository;
use \Hal\GithubBundle\Entity\AuthentifiableInterface;

interface OwnerServiceInterface
{
    public function findOwnerByAuth(AuthentifiableInterface $auth);
}