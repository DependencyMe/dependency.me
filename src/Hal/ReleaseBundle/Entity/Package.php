<?php

namespace Hal\ReleaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Package
 */
class Package
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var version
     */
    private $currentVersion;

    /**
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * @var string
     */
    private $homepage;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $requirements;

    /**
     * @var \Hal\ReleaseBundle\Entity\Owner
     */
    private $owner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->requirements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Package
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
     * Set currentVersion
     *
     * @param version $currentVersion
     * @return Package
     */
    public function setCurrentVersion($currentVersion)
    {
        $this->currentVersion = $currentVersion;
    
        return $this;
    }

    /**
     * Get currentVersion
     *
     * @return version 
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     * @return Package
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    
        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime 
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set homepage
     *
     * @param string $homepage
     * @return Package
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    
        return $this;
    }

    /**
     * Get homepage
     *
     * @return string 
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Package
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
     * Add requirements
     *
     * @param \Hal\ReleaseBundle\Entity\Requirement $requirements
     * @return Package
     */
    public function addRequirement(\Hal\ReleaseBundle\Entity\Requirement $requirements)
    {
        $this->requirements[] = $requirements;
    
        return $this;
    }

    /**
     * Remove requirements
     *
     * @param \Hal\ReleaseBundle\Entity\Requirement $requirements
     */
    public function removeRequirement(\Hal\ReleaseBundle\Entity\Requirement $requirements)
    {
        $this->requirements->removeElement($requirements);
    }

    /**
     * Get requirements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Set owner
     *
     * @param \Hal\ReleaseBundle\Entity\Owner $owner
     * @return Package
     */
    public function setOwner(\Hal\ReleaseBundle\Entity\Owner $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Hal\ReleaseBundle\Entity\Owner 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}