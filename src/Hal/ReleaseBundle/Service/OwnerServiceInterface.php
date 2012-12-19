<?php
namespace Hal\ReleaseBundle\Service;
use \Hal\GithubBundle\Auth\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use \Hal\GithubBundle\Entity\Authentifiable;
use \Hal\GithubBundle\Entity\AuthentifiableInterface;
use \Hal\ReleaseBundle\Repository\OwnerRepositoryInterface;

interface OwnerServiceInterface
{
    public function authentificate();

    public function findOwnerByAuth(AuthentifiableInterface $auth);

}