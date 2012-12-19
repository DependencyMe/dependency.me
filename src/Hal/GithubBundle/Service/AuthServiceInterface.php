<?php
namespace Hal\GithubBundle\Service;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

interface AuthServiceInterface
{
    public function authentificate(AuthentifiableInterface $user);
}