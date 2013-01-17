<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;


use Hal\GithubBundle\Entity\Owner;
use Hal\GithubBundle\Entity\Repository;
use Hal\GithubBundle\Entity\Branche;
use Hal\GithubBundle\Repository\OwnerRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Hal\GithubBundle\Repository\GithubRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Hal\GithubBundle\Entity\OwnerInterface;

class OwnerService implements OwnerServiceInterface
{


    private $ownerRepository;
    private $githubRepository;


    function __construct(OwnerRepositoryInterface $ownerRepository, GithubRepositoryInterface $githubRepository)
    {
        $this->ownerRepository = $ownerRepository;
        $this->githubRepository = $githubRepository;
    }

    /**
     * Save the given owner
     *
     * @param \Hal\GithubBundle\Entity\OwnerInterface $owner
     */
    public function saveOwner(OwnerInterface $owner) {
        $this->ownerRepository->saveOwner($owner);
    }

    /**
     * Loads the user by a given UserResponseInterface object.
     *
     * @param UserResponseInterface $response
     * @return UserInterface
     * @throws UsernameNotFoundException if the user is not found
     */
    public function getUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return $this->ownerRepository->getUserByOAuthUserResponse($response);
    }


    /**
     * Get owner by its login
     *
     * @param string $name
     * @return Owner
     */
    public function getOwnerByLogin($name)
    {
        return $this->ownerRepository->getOwnerByLogin($name);
    }


    /**
     * Synchronize informations about Owner
     *
     * @param OwnerInterface
     */
    public function synchronize(OwnerInterface $user)
    {
        $user
            ->setEmail($this->githubRepository->getEmail($user))
            ->setGravatarUrl($this->githubRepository->getGravatarUrl($user))
            ->setLogin($this->githubRepository->getLogin($user))
            ->setName($this->githubRepository->getName($user))
            ->setUrl($this->githubRepository->getUrl($user));

        //
        // Repositories
        $gitRepositories = $this->githubRepository->getPublicRepositories($user);
        foreach ($gitRepositories as $gitRepo) {

            $repository = new Repository;
            $repository
                ->setName($gitRepo->name)
                ->setUrl($gitRepo->url)
                ->setGitUrl($gitRepo->git_url)
                ->setPrivate(false)
                ->setOwner($user);

            $gitBranches = $this->githubRepository->getBranchesOfRepository($user, $gitRepo->name);

            foreach ($gitBranches as $gitBranche) {
                $branche = new Branche;
                $branche
                    ->setName($gitBranche->name)
                    ->setRepository($repository);

                $repository->addBranche($branche);
            }

            $user->addRepository($repository);

        }
    }

}
