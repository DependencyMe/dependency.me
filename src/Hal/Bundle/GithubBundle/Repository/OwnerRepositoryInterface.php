<?php
namespace Hal\Bundle\GithubBundle\Repository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Hal\Bundle\GithubBundle\Entity\Owner;

interface OwnerRepositoryInterface
{

    public function getUserByOAuthUserResponse(UserResponseInterface $response);

    public function getOwnerByLogin($name);

    public function getUserByAccessToken($name);

    public function saveOwner(Owner $owner);
}