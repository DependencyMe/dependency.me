<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Hal\GithubBundle\Entity\Owner;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Hal\GithubBundle\Repository\OwnerRepositoryInterface;
use Hal\GithubBundle\Service\UserServiceInterface;
class AuthService implements AuthServiceInterface
{
    private $clientId;
    private $request;
    private $redirectUri;
    private $ownerRepository;
    private $userService;
    private $clientSecret;
    private $scopes = array();

    function __construct(ContainerInterface $container, OwnerRepositoryInterface $ownerRepository, UserServiceInterface $userService , $appClientId, $appClientSecret, $redirectUri)
    {
        $this->clientId = $appClientId;
        $this->clientSecret = $appClientSecret;
        $this->ownerRepository = $ownerRepository;
        $this->userService = $userService;
        $this->request = $container->get('request');
        $this->session = $container->get('session');
        $this->redirectUri = $redirectUri;
    }


    public function authentificate()
    {
        $user = $this->session->get('owner.auth.user');
        if (!$user) {
            $user = new Owner();
        }

        $this->doAuthentification($user);
        $this->session->set('owner.auth.user', $user);

        if (null != $user->getPermanentAccessToken()) {
            // find owner
            $owner = $this->ownerRepository->findOwnerByAuth($user);

            if (!$owner) {
                $owner = new Owner();
                $owner->setPermanentAccessToken($user->getPermanentAccessToken());

                $this->userService->synchronize($owner);


                $this->ownerRepository->saveOwner($owner);
            }
        }

        return $owner;

    }


    private function doAuthentification(AuthentifiableInterface $user)
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


        $url = 'https://github.com/login/oauth/authorize?'
            . http_build_query(array(
                'client_id' => $this->clientId,
                'redirect_uri' => $this->redirectUri,
            ))
            . '&amp;' . 'scope=' . implode(',', $this->scopes);


        $response = new RedirectResponse($url);
        $response->send();
    }

    private function getPermanentAccess(AuthentifiableInterface &$user)
    {
        $url = sprintf('https://github.com/login/oauth/access_token?client_id=%1$s&redirect_uri=%2$s&client_secret=%3$s&code=%4$s'
            , $this->clientId, $this->redirectUri, $this->clientSecret, $user->getTemporaryCode()
        );
        parse_str(file_get_contents($url), $response);

        if (!isset($response['access_token'])) {
            throw new \LogicException('Access token does not exist');
        }

        $token = $response['access_token'];

        if (strlen($token) == 0) {
            throw new \LogicException('Access token is empty');
        }

        $user->setPermanentAccessToken($token);
    }

    public function addScope($scope)
    {
        array_push($this->scopes, $scope);
        return $this;
    }
}
