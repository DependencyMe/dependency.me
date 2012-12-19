<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthService implements AuthServiceInterface
{
    private $clientId;
    private $request;
    private $redirectUri;
    private $clientSecret;

    function __construct(Request $request, $appClientId, $appClientSecret, $redirectUri)
    {
        $this->clientId = $appClientId;
        $this->clientSecret = $appClientSecret;
        $this->request = $request;
        $this->redirectUri = $redirectUri;
    }


    public function authentificate(AuthentifiableInterface $user)
    {
        // Pattern Template

        // 1. ask for temporary code
        if (null === $user->getTemporaryCode()) {
            return $this->getTemporaryAccess($user);
        }

        // 2. ask for permanent access (with token)
        if (null === $user->getPermanentAccessToken()) {
            return $this->getPermanentAccess($user);
        }

        return;
    }

    private function getTemporaryAccess(AuthentifiableInterface $user)
    {
        if ($this->request->isMethod('POST')) {
            $code = $this->request->get('code');
            if (null !== $code) {
                $user->setTemporaryCode($code);
                return;
            }
        }

        return new RedirectResponse(sprintf('https://github.com/login/oauth/authorize?client_id=%1$s&redirect_uri=%2$s'
            , $this->clientId, $this->redirectUri
        ));
    }

    private function getPermanentAccess(AuthentifiableInterface $user)
    {
        if ($this->request->isMethod('POST')) {
            $token = $this->request->get('access_token');
            if (null !== $token) {
                $user->setPermanentAccessToken($token);
                return;
            }
        }

        return new RedirectResponse(sprintf('https://github.com/login/oauth/access_token?client_id=%1$s&redirect_uri=%2$s&client_secret=%3$s&code=%4$s'
            , $this->clientId, $this->redirectUri, $this->clientSecret, $user->getTemporaryCode()
        ));
    }
}
