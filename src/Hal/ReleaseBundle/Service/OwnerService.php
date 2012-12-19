<?php
namespace Hal\ReleaseBundle\Service;
use \Hal\GithubBundle\Auth\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use \Hal\GithubBundle\Entity\Authentifiable;
use \Hal\GithubBundle\Entity\AuthentifiableInterface;
use \Hal\ReleaseBundle\Repository\OwnerRepositoryInterface;

class OwnerService implements OwnerServiceInterface
{
    private $authService;
    private $session;
    private $ownerRepository;

    function __construct(AuthServiceInterface $authService, SessionInterface $session, OwnerRepositoryInterface $ownerRepo)
    {
        $this->authService = $authService;
        $this->session = $session;
        $this->ownerRepository = $ownerRepo;
    }


    public function authentificate()
    {

        $user = $this->session->get('owner.auth.user');
        if (!$user) {
            $user = new Authentifiable();
        }

        $this->authService->authentificate($user);
        $this->session->set('owner.auth.user', $user);

        if (null != $user->getPermanentToken()) {
            // find owner
            $owner = $this->findOwnerByAuth($user);

            if (!$owner) {
                $owner = new \Hal\ReleaseBundle\Entity\Owner();
                $owner->setToken($user->getPermanentAccessToken());
                $this->ownerRepository->saveOwner($owner);

            }
        }

    }

    public function findOwnerByAuth(AuthentifiableInterface $auth)
    {
        return $this->ownerRepository->findOwnerByAuth($auth);
    }

}