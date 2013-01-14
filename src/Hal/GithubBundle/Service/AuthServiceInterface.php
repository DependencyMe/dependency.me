<?php
namespace Hal\GithubBundle\Service;
use Hal\GithubBundle\Entity\AuthentifiableInterface;

interface AuthServiceInterface
{
    const SCOPE_USER = 'user';
    const SCOPE_USER_EMAIL = 'user:email';
    const SCOPE_USER_FOLLOW = 'user:follow';
    const SCOPE_REPO_PUBLIC = 'public_repo';
    const SCOPE_REPO_PRIVATE = 'repo';
    const SCOPE_REPO_STATUS = 'repo:status';
    const SCOPE_REPO_DELETE = 'delete_repo';
    const SCOPE_NOTIFICATIONS = 'notifications';
    const SCOPE_GIST = 'gist';


    public function authentificate(AuthentifiableInterface $user);
}