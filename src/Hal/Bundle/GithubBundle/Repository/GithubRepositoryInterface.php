<?php
namespace Hal\Bundle\GithubBundle\Repository;
use Hal\Bundle\GithubBundle\Entity\OwnerInterface;


interface GithubRepositoryInterface
{

    public function getEmail(OwnerInterface $user);

    public function getName(OwnerInterface $user);

    public function getGravatarUrl(OwnerInterface $user);

    public function getLogin(OwnerInterface $user);

    public function getUrl(OwnerInterface $user);

    public function getPublicRepositories(OwnerInterface $user);

    public function getBranchesOfRepository(OwnerInterface $user, $repository);
}