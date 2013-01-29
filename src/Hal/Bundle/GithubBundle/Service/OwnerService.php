<?php

namespace Hal\Bundle\GithubBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Hal\Bundle\GithubBundle\Entity\Owner;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Hal\Bundle\GithubBundle\Entity\Branche;
use Hal\Bundle\GithubBundle\Repository\OwnerRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Hal\Bundle\GithubBundle\Repository\GithubRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Hal\Bundle\GithubBundle\Entity\OwnerInterface;
use Hal\Bundle\GithubBundle\Repository\RepositoryRepositoryInterface;
use Symfony\Component\Security\Acl\Model\AclProviderInterface;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;

class OwnerService implements OwnerServiceInterface
{

    private $ownerRepository;
    private $githubRepository;
    private $repositoryRepository;
    private $aclProvider;

    function __construct(OwnerRepositoryInterface $ownerRepository, RepositoryRepositoryInterface $repositoryRepository, GithubRepositoryInterface $githubRepository, AclProviderInterface $aclProvider
    )
    {
        $this->ownerRepository = $ownerRepository;
        $this->githubRepository = $githubRepository;
        $this->repositoryRepository = $repositoryRepository;
        $this->aclProvider = $aclProvider;
    }

    /**
     * Save the given owner
     *
     * @param \Hal\Bundle\GithubBundle\Entity\OwnerInterface $owner
     */
    public function saveOwner(OwnerInterface $owner)
    {
        $this->ownerRepository->saveOwner($owner);

        // Acl
        $securityIdentity = UserSecurityIdentity::fromAccount($owner);


        foreach ($owner->getRepositories() as $repository) {
            $objectIdentity = ObjectIdentity::fromDomainObject($repository);

            try {

                $this->aclProvider->findAcl($objectIdentity);
            } catch (AclNotFoundException $e) {

                $acl = $this->aclProvider->createAcl($objectIdentity);
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $this->aclProvider->updateAcl($acl);
            }
        }
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
     * @param OwnerInterface $user
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
        // Stock old repositories infos
        $oldRepos = array();
        $repos = $this->repositoryRepository->getByOwner($user);
        foreach ($repos as $repo) {
            $oldRepos[$repo->getName()] = (object) array(
                    'enabled' => $repo->getEnabled()
            );
        }

        
        $this->repositoryRepository->removeByOwner($user);

        //
        // Repositories
        $gitRepositories = $this->githubRepository->getPublicRepositories($user);
        foreach ($gitRepositories as $gitRepo) {


            $repository = new Repository;

            $repository
                ->setName($gitRepo->name)
                ->setUrl($gitRepo->html_url)
                ->setGitUrl($gitRepo->git_url)
                ->setPrivate(false)
                ->setOwner($user);

            if (isset($oldRepos[$gitRepo->name])) {
                $repository->setEnabled($oldRepos[$gitRepo->name]->enabled);
            }

            foreach ($repository->getBranches() as $branche) {
                $repository->removeBranche($branche);
            }

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
