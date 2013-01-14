<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;

interface UserServiceInterface
{

    public function getEmail(AuthentifiableInterface $user);

    public function getGravatar(AuthentifiableInterface $user);

    public function getLogin(AuthentifiableInterface $user);

    public function getUrl(AuthentifiableInterface $user);

    public function getPublicRepositories(AuthentifiableInterface $user);

    public function getBranchesOfRepository(AuthentifiableInterface $user, $repository);
}
