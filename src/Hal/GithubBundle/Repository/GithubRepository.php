<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\OwnerInterface;


class GithubRepository implements GithubRepositoryInterface
{

    public static $cache = array();

    protected function doRequest($request, OwnerInterface $user)
    {
        $request = ltrim($request, '/');

        $key = md5($user->getPermanentAccessToken() . $request);

        if (!isset(self::$cache[$key])) {
            $url = 'https://api.github.com/' . $request . '?access_token=' . $user->getPermanentAccessToken();
            $response = file_get_contents($url);
            self::$cache[$key] = json_decode($response);
        }

        return self::$cache[$key];
    }

    public function getEmail(OwnerInterface $user)
    {
        $response = $this->doRequest('/user/emails', $user);
        return $response[0];
    }

    public function getName(OwnerInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->name;
    }

    public function getGravatarUrl(OwnerInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->avatar_url;
    }

    public function getLogin(OwnerInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->login;
    }

    public function getUrl(OwnerInterface $user)
    {
        $response = $this->doRequest('/user', $user);
        return $response->url;
    }

    public function getPublicRepositories(OwnerInterface $user)
    {
        $response = $this->doRequest('/user/repos', $user);
        return (array)$response;
    }

    public function getBranchesOfRepository(OwnerInterface $user, $repository)
    {
        $response = $this->doRequest(
            sprintf('/repos/%s/%s/branches', $this->getLogin($user), $repository),
            $user);
        return $response;
    }
}