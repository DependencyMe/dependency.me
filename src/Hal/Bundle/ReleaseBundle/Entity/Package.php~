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
    private $url;


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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $requiredBy;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->requiredBy = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add requiredBy
     *
     * @param \Hal\ReleaseBundle\Entity\Requirement $requiredBy
     * @return Package
     */
    public function addRequiredBy(\Hal\ReleaseBundle\Entity\Requirement $requiredBy)
    {
        $this->requiredBy[] = $requiredBy;
    
        return $this;
    }

    /**
     * Remove requiredBy
     *
     * @param \Hal\ReleaseBundle\Entity\Requirement $requiredBy
     */
    public function removeRequiredBy(\Hal\ReleaseBundle\Entity\Requirement $requiredBy)
    {
        $this->requiredBy->removeElement($requiredBy);
    }

    /**
     * Get requiredBy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRequiredBy()
    {
        return $this->requiredBy;
    }
}