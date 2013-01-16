<?php
namespace Hal\GithubBundle\Security\Authentication\Provider;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Hal\GithubBundle\Security\Authentication\Token\GithubUserToken;

use Hal\GithubBundle\Service\AuthServiceInterface;

class GithubProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function authenticate(TokenInterface $token)
    {

        try {
            $user = $this->authService->authentificate();
            $authenticatedToken = new GithubUserToken(array('ROLE_USER'));
            $authenticatedToken->setUser($user);
            return $authenticatedToken;
        } catch (Exception $e) {
            throw new AuthenticationException('The Github authentication failed.');
        }

    }

    public function supports(TokenInterface $token)
    {
        var_dump(__FILE__);
        var_dump($token);exit;
        return $token instanceof GithubUserToken;
    }
}