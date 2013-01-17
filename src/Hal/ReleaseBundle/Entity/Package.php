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
}