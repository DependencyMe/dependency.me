<?php

namespace Hal\Bundle\ReleaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Declaration
 */
class Declaration
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Hal\Bundle\GithubBundle\Entity\Branche
     */
    private $branche;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $requirements;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->requirements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set branche
     *
     * @param \Hal\Bundle\GithubBundle\Entity\Branche $branche
     * @return Declaration
     */
    public function setBranche(\Hal\Bundle\GithubBundle\Entity\Branche $branche = null)
    {
        $this->branche = $branche;

        return $this;
    }

    /**
     * Get branche
     *
     * @return \Hal\Bundle\GithubBundle\Entity\Branche
     */
    public function getBranche()
    {
        return $this->branche;
    }

    /**
     * Add requirements
     *
     * @param \Hal\Bundle\ReleaseBundle\Entity\Requirement $requirements
     * @return Declaration
     */
    public function addRequirement(\Hal\Bundle\ReleaseBundle\Entity\Requirement $requirements)
    {
        $this->requirements[] = $requirements;

        return $this;
    }

    /**
     * Remove requirements
     *
     * @param \Hal\Bundle\ReleaseBundle\Entity\Requirement $requirements
     */
    public function removeRequirement(\Hal\Bundle\ReleaseBundle\Entity\Requirement $requirements)
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
     * @var \DateTime
     */
    private $lastUpdate;


    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Declaration
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