<?php
namespace Hal\GithubBundle\Service;
use Hal\GithubBundle\Entity\OwnerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

interface OwnerServiceInterface
{

    public function synchronize(OwnerInterface $user);

    public function getOwnerByLogin($name);

    public function getUserByOAuthUserResponse(UserResponseInterface $response);

}
