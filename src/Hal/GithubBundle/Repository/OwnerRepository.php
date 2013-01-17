<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Hal\GithubBundle\Entity\Owner;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class OwnerRepository implements OwnerRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Loads the user by a given UserResponseInterface object.
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function getUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $owner = $this->getUserByAccessToken($response->getAccessToken());

        if (!$owner) {

            $owner = new Owner;
            $owner
                ->setLogin($response->getNickname())
                ->setName($response->getRealName())
                ->setPermanentAccessToken($response->getAccessToken());

            $this->saveOwner($owner);

        }

        return $owner;
    }


    public function getUserByAccessToken($accessToken)
    {
        $query = $this->em->createQuery("
            SELECT
                o
            FROM
                HalGithubBundle:Owner o
            WHERE
                o.permanentAccessToken = :permanent_access_token
            ");
        $query->setParameter('permanent_access_token', $accessToken);
        return $query->getOneOrNullResult();
    }


    public function getOwnerByLogin($login)
    {
        $query = $this->em->createQuery("
            SELECT
                o
            FROM
                HalGithubBundle:Owner o
            WHERE
                o.login = :login
            ");
        $query->setParameter('login', $login);
        return $query->getOneOrNullResult();
    }

    public function saveOwner(Owner $owner)
    {
        $this->em->persist($owner);
        $this->em->flush();
    }
}