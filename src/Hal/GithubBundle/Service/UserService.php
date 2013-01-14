<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

use Hal\GithubBundle\Entity\Owner;
use Hal\GithubBundle\Entity\Repository;
use Hal\GithubBundle\Entity\Branche;

use Symfony\Component\DependencyInjection\ContainerInterface;

class UserService extends AbstractService implements UserServiceInterface
{

    public function synchronize(AuthentifiableInterface $user)
    {
        $user
            ->setEmail($this->getEmail($user))
            ->setGravatarUrl($this->getGravatarUrl($user))
            ->setLogin($this->getLogin($user))
            ->setName($this->getName($user))
            ->setUrl($this->getUrl($user));

        //
        // Repositories
        $gitRepositories = $this->getPublicRepositories($user);
        foreach ($gitRepositories as $gitRepo) {

            $repository = new Repository;
            $repository
                ->setName($gitRepo->name)
                ->setUrl($gitRepo->url)
                ->setGitUrl($gitRepo->git_url)
                ->setPrivate(false)
                ->setOwner($user);

            $gitBranches = $this->getBranchesOfRepository($user, $gitRepo->name);

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


    public function findOwnerByAuth(AuthentifiableInterface $auth)
    {
        return $this->ownerRepository->findOwnerByAuth($auth);
    }

    private function getEmail(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user/emails', $user);
        return $response[0];
    }

    private function getName(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->name;
    }

    private function getGravatarUrl(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->avatar_url;
    }

    private function getLogin(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        file_put_contents('/tmp/dump.txt', ob_get_clean());
        return $response->login;
    }

    private function getUrl(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->url;
    }

    private function getPublicRepositories(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user/repos', $user);
        return (array)$response;
    }

    private function getBranchesOfRepository(AuthentifiableInterface $user, $repository)
    {
        $response = $this->doRequest(
            sprintf('/repos/%s/%s/branches', $this->getLogin($user), $repository),
            $user);
        return $response;
    }
}
