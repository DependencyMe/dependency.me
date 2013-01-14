<?php

namespace Hal\GithubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Owner
 */
class Owner implements AuthentifiableInterface
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $repository;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->repository = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Add repository
     *
     * @param \Hal\GithubBundle\Entity\Repository $repository
     * @return Owner
     */
    public function addRepository(\Hal\GithubBundle\Entity\Repository $repository)
    {
        $this->repository[] = $repository;
    
        return $this;
    }

    /**
     * Remove repository
     *
     * @param \Hal\GithubBundle\Entity\Repository $repository
     */
    public function removeRepository(\Hal\GithubBundle\Entity\Repository $repository)
    {
        $this->repository->removeElement($repository);
    }

    /**
     * Get repository
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRepository()
    {
        return $this->repository;
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
}