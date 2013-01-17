<?php

namespace Hal\GithubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Owner
 */
class Owner implements OwnerInterface, UserInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $permanentAccessToken;

    /**
     * @var string
     */
    private $temporaryCode;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $gravatarUrl;

    /**
     * @var string
     */
    private $name;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set permanentAccessToken
     *
     * @param string $permanentAccessToken
     * @return Owner
     */
    public function setPermanentAccessToken($permanentAccessToken)
    {
        $this->permanentAccessToken = $permanentAccessToken;

        return $this;
    }

    /**
     * Get permanentAccessToken
     *
     * @return string
     */
    public function getPermanentAccessToken()
    {
        return $this->permanentAccessToken;
    }

    /**
     * Set temporaryCode
     *
     * @param string $temporaryCode
     * @return Owner
     */
    public function setTemporaryCode($temporaryCode)
    {
        $this->temporaryCode = $temporaryCode;

        return $this;
    }

    /**
     * Get temporaryCode
     *
     * @return string
     */
    public function getTemporaryCode()
    {
        return $this->temporaryCode;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Owner
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Owner
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }



    /**
     * Set name
     *
     * @param string $name
     * @return Owner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var string
     */
    private $email;


    /**
     * Set email
     *
     * @param string $email
     * @return Owner
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set gravatarUrl
     *
     * @param string $gravatarUrl
     * @return Owner
     */
    public function setGravatarUrl($gravatarUrl)
    {
        $this->gravatarUrl = $gravatarUrl;

        return $this;
    }

    /**
     * Get gravatarUrl
     *
     * @return string
     */
    public function getGravatarUrl()
    {
        return $this->gravatarUrl;
    }






    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $repositories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->repositories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add repositories
     *
     * @param \Hal\GithubBundle\Entity\Repository $repositories
     * @return Owner
     */
    public function addRepository(\Hal\GithubBundle\Entity\Repository $repositories)
    {
        $this->repositories[] = $repositories;
    
        return $this;
    }

    /**
     * Remove repositories
     *
     * @param \Hal\GithubBundle\Entity\Repository $repositories
     */
    public function removeRepository(\Hal\GithubBundle\Entity\Repository $repositories)
    {
        $this->repositories->removeElement($repositories);
    }

    /**
     * Get repositories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRepositories()
    {
        return $this->repositories;
    }




    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getLogin();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        return;
    }




}