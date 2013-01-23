<?php

namespace Hal\Bundle\GithubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repository
 */
class Repository
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
     * @var string
     */
    private $gitUrl;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $private = 0;

    /**
     * @var integer
     */
    private $enabled = 0;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $branches;

    /**
     * @var \Hal\Bundle\GithubBundle\Entity\Owner
     */
    private $owner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->branches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function updateDate()
    {
        $this->lastUpdate = new \DateTime();
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
     * @return Repository
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
     * Set gitUrl
     *
     * @param string $gitUrl
     * @return Repository
     */
    public function setGitUrl($gitUrl)
    {
        $this->gitUrl = $gitUrl;
    
        return $this;
    }

    /**
     * Get gitUrl
     *
     * @return string 
     */
    public function getGitUrl()
    {
        return $this->gitUrl;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Repository
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
     * Set private
     *
     * @param integer $private
     * @return Repository
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    
        return $this;
    }

    /**
     * Get private
     *
     * @return integer 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     * @return Repository
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return integer 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Add branches
     *
     * @param \Hal\Bundle\GithubBundle\Entity\Branche $branches
     * @return Repository
     */
    public function addBranche(\Hal\Bundle\GithubBundle\Entity\Branche $branches)
    {
        $this->branches[] = $branches;
    
        return $this;
    }

    /**
     * Remove branches
     *
     * @param \Hal\Bundle\GithubBundle\Entity\Branche $branches
     */
    public function removeBranche(\Hal\Bundle\GithubBundle\Entity\Branche $branches)
    {
        $this->branches->removeElement($branches);
    }

    /**
     * Get branches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBranches()
    {
        return $this->branches;
    }

    /**
     * Set owner
     *
     * @param \Hal\Bundle\GithubBundle\Entity\Owner $owner
     * @return Repository
     */
    public function setOwner(\Hal\Bundle\GithubBundle\Entity\Owner $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Hal\Bundle\GithubBundle\Entity\Owner
     */
    public function getOwner()
    {
        return $this->owner;
    }
    /**
     * @var \DateTime
     */
    private $lastUpdate;


    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Repository
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    
        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
}