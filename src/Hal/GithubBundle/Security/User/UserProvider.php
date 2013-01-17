<?php
namespace Hal\GithubBundle\Security\User;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Hal\GithubBundle\Service\OwnerServiceInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserProvider implements OAuthAwareUserProviderInterface, UserProviderInterface
{


    private $ownerService;

    function __construct(OwnerServiceInterface $ownerService)
    {
        $this->ownerService = $ownerService;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return $this->ownerService->getUserByOAuthUserResponse($response);
    }

    public function loadUserByUsername($username)
    {
        return $this->ownerService->getOwnerByLogin($username);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->ownerService->getOwnerByLogin($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Hal\\GithubBundle\\Entity\\Owner';
    }


}
