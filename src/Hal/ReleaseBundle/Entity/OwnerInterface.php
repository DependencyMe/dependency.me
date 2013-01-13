<?php

namespace Hal\ReleaseBundle\Entity;

interface OwnerInterface
{

    public function getId();

    /**
     * Set name
     *
     * @param string $name
     * @return Owner
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

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

}