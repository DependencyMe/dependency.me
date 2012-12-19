<?php
namespace Hal\GithubBundle\Auth;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

interface AuthServiceInterface
{
    public function authentificate(AuthentifiableInterface $user);
}
