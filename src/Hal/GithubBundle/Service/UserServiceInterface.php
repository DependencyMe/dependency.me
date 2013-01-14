<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;

interface UserServiceInterface
{

    public function synchronize(AuthentifiableInterface $user);

}
