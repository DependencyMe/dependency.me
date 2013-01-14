<?php

namespace Hal\GithubBundle\Entity;

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
    private $private;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $branche;

    /**
     * @var \Hal\GithubBundle\Entity\Owner
     */
    private $owner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->branche = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add branche
     *
     * @param \Hal\GithubBundle\Entity\Branche $branche
     * @return Repository
     */
    public function addBranche(\Hal\GithubBundle\Entity\Branche $branche)
    {
        $this->branche[] = $branche;
    
        return $this;
    }

    /**
     * Remove branche
     *
     * @param \Hal\GithubBundle\Entity\Branche $branche
     */
    public function removeBranche(\Hal\GithubBundle\Entity\Branche $branche)
    {
        $this->branche->removeElement($branche);
    }

    /**
     * Get branche
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBranche()
    {
        return $this->branche;
    }

    /**
     * Set owner
     *
     * @param \Hal\GithubBundle\Entity\Owner $owner
     * @return Repository
     */
    public function setOwner(\Hal\GithubBundle\Entity\Owner $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Hal\GithubBundle\Entity\Owner 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}