<?php
namespace Hal\GithubBundle\Service;
use Symfony\Component\HttpFoundation\Request;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractService
{

    private static $cache = array();

    protected function doRequest($request, AuthentifiableInterface $user)
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

}
