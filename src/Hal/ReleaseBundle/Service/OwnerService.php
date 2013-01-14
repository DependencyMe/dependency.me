<?php
namespace Hal\ReleaseBundle\Service;
use \Hal\GithubBundle\Service\AuthServiceInterface;
use \Hal\GithubBundle\Service\UserServiceInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use \Hal\GithubBundle\Entity\Authentifiable;
use \Hal\GithubBundle\Entity\AuthentifiableInterface;
use \Hal\ReleaseBundle\Repository\OwnerRepositoryInterface;
use \Hal\ReleaseBundle\Entity\Owner;

class OwnerService implements OwnerServiceInterface
{
    private $authService;
    private $userService;
    private $session;
    private $ownerRepository;

    function __construct(AuthServiceInterface $authService, UserServiceInterface $userService, SessionInterface $session, OwnerRepositoryInterface $ownerRepo)
    {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->session = $session;
        $this->ownerRepository = $ownerRepo;

        // Scopes (authorizations)
        $this->authService
            ->addScope(AuthServiceInterface::SCOPE_USER_EMAIL)
            ->addScope(AuthServiceInterface::SCOPE_USER)
            ->addScope(AuthServiceInterface::SCOPE_REPO_PUBLIC);
    }


    public function authentificate()
    {
        $user = $this->session->get('owner.auth.user');
        if (!$user) {
            $user = new Owner();
        }

        $this->authService->authentificate($user);
        $this->session->set('owner.auth.user', $user);

        if (null != $user->getPermanentAccessToken()) {
            // find owner
            $owner = $this->findOwnerByAuth($user);

            if (!$owner) {
                $owner = new \Hal\ReleaseBundle\Entity\Owner();
                $owner->setPermanentAccessToken($user->getPermanentAccessToken());

                $owner->setEmail($this->userService->getEmail($user));
                $owner->setGravatarId($this->userService->getGravatar($user));
                $owner->setLogin($this->userService->getLogin($user));
                $owner->setGithubUrl($this->userService->getUrl($user));


                $this->ownerRepository->saveOwner($owner);
            }
        }

    }

    public function findOwnerByAuth(AuthentifiableInterface $auth)
    {
        return $this->ownerRepository->findOwnerByAuth($auth);
    }

}