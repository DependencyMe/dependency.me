<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;

class UserService extends AbstractService implements UserServiceInterface
{

    public function getEmail(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user/emails', $user);
        return $response[0];
    }

    public function getGravatar(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->gravatar_id;
    }

    public function getLogin(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        file_put_contents('/tmp/dump.txt',ob_get_clean());
        return $response->login;
    }

    public function getUrl(AuthentifiableInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->url;
    }

    public function getPublicRepositories(AuthentifiableInterface $user) {
        $response = $this->doRequest('/user/repos', $user);
        return (array) $response;
    }

    public function getBranchesOfRepository(AuthentifiableInterface $user, $repository) {
        $response = $this->doRequest(
            sprintf('/repos/%s/%s/branches', $this->getLogin($user), $repository),
            $user);
        return $response;
    }
}
