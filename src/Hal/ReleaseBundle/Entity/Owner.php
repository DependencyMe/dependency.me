<?php

namespace Hal\ReleaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Hal\GithubBundle\Entity\AuthentifiableInterface;
use \Hal\GithubBundle\Entity\Authentifiable;

/**
 * Owner
 */
class Owner extends Authentifiable implements OwnerInterface, AuthentifiableInterface
{

    /**
     * @var integer
     */
    private $id;


    /**
     * @var string
     */
    private $email;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $package;

    /**
     * @var string
     */
    private $temporaryCode;

    /**
     * @var string
     */
    private $permanentAccessToken;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $gravatarId;

    /**
     * @var string
     */
    private $githubUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->package = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add package
     *
     * @param \Hal\ReleaseBundle\Entity\Package $package
     * @return Owner
     */
    public function addPackage(\Hal\ReleaseBundle\Entity\Package $package)
    {
        $this->package[] = $package;

        return $this;
    }

    /**
     * Remove package
     *
     * @param \Hal\ReleaseBundle\Entity\Package $package
     */
    public function removePackage(\Hal\ReleaseBundle\Entity\Package $package)
    {
        $this->package->removeElement($package);
    }

    /**
     * Get package
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackage()
    {
        return $this->package;
    }

    public function setPermanentAccessToken($permanentAccessToken)
    {
        $this->permanentAccessToken = $permanentAccessToken;
    }

    public function getPermanentAccessToken()
    {
        return $this->permanentAccessToken;
    }

    public function setTemporaryCode($temporaryCode)
    {
        $this->temporaryCode = $temporaryCode;
    }

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
     * Set gravatarId
     *
     * @param string $gravatarId
     * @return Owner
     */
    public function setGravatarId($gravatarId)
    {
        $this->gravatarId = $gravatarId;

        return $this;
    }

    /**
     * Get gravatarId
     *
     * @return string
     */
    public function getGravatarId()
    {
        return $this->gravatarId;
    }

    /**
     * Set githubUrl
     *
     * @param string $githubUrl
     * @return Owner
     */
    public function setGithubUrl($githubUrl)
    {
        $this->githubUrl = $githubUrl;

        return $this;
    }

    /**
     * Get githubUrl
     *
     * @return string
     */
    public function getGithubUrl()
    {
        return $this->githubUrl;
    }
}