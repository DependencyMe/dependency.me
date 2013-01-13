<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AuthService implements AuthServiceInterface
{
    private $clientId;
    private $request;
    private $redirectUri;
    private $clientSecret;

    function __construct(ContainerInterface $container, $appClientId, $appClientSecret, $redirectUri)
    {
        $this->clientId = $appClientId;
        $this->clientSecret = $appClientSecret;
        $this->request = $container->get('request');
        ;
        $this->redirectUri = $redirectUri;
    }


    public function authentificate(AuthentifiableInterface $user)
    {
        // Pattern Template
        // 1. ask for temporary code
        if (null === $user->getTemporaryCode()) {
            $this->getTemporaryAccess($user);
        }

        // 2. ask for permanent access (with token)
        if (null === $user->getPermanentAccessToken()) {
            $this->getPermanentAccess($user);
        }

        return;
    }

    private function getTemporaryAccess(AuthentifiableInterface &$user)
    {

        $code = $this->request->get('code');
        if (null !== $code) {
            $user->setTemporaryCode($code);
            return;
        }

        $response = new RedirectResponse(sprintf('https://github.com/login/oauth/authorize?client_id=%1$s&redirect_uri=%2$s'
            , $this->clientId, $this->redirectUri
        ));
        $response->send();
    }

    private function getPermanentAccess(AuthentifiableInterface &$user)
    {
        $url = sprintf('https://github.com/login/oauth/access_token?client_id=%1$s&redirect_uri=%2$s&client_secret=%3$s&code=%4$s'
            , $this->clientId, $this->redirectUri, $this->clientSecret, $user->getTemporaryCode()
        );
        parse_str(file_get_contents($url));

        $token = $this->request->get('access_token');
        if (null !== $token) {
            $user->setPermanentAccessToken($token);
            return;
        }
    }
}
