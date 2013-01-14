<?php

namespace Hal\ReleaseBundle\Entity;

interface OwnerInterface
{

    public function getId();

    /**
     * Set login
     *
     * @param string $name
     * @return Owner
     */
    public function setLogin($name);

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin();

    /**
     * Set email
     *
     * @param string $email
     * @return Owner
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail();

    /**
     * Add package
     *
     * @param \Hal\ReleaseBundle\Entity\Package $package
     * @return Owner
     */
    public function addPackage(\Hal\ReleaseBundle\Entity\Package $package);

    /**
     * Remove package
     *
     * @param \Hal\ReleaseBundle\Entity\Package $package
     */
    public function removePackage(\Hal\ReleaseBundle\Entity\Package $package);

    /**
     * Get package
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPackage();


    /**
     * Set gravatar Id
     *
     * @param string $name
     * @return Owner
     */
    public function setGravatarId($name);

    /**
     * Get gravatar id
     *
     * @return string
     */
    public function getGravatarId();

    /**
     * Set GithubUrl
     *
     * @param string $name
     * @return Owner
     */
    public function setGithubUrl($name);

    /**
     * Get GithubUrl
     *
     * @return string
     */
    public function getGithubUrl();

}