<?php

namespace Hal\Bundle\ReleaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requirement
 */
class Requirement implements RequirementInterface
{
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var constraint
     */
    private $requiredVersion;

    /**
     * @var requirementstatus
     */
    private $status = RequirementInterface::STATUS_UNKNOWN;

    /**
     * @var \Hal\Bundle\ReleaseBundle\Entity\Package
     */
    private $package;

    /**
     * @var \Hal\Bundle\ReleaseBundle\Entity\Declaration
     */
    private $declaration;


    public function __construct() {
        $this->requiredVersion = new \Hal\Bundle\ReleaseBundle\Value\Constraint('*','=');
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
     * Set status
     *
     * @param requirementstatus $status
     * @return Requirement
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return requirementstatus 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set package
     *
     * @param \Hal\Bundle\ReleaseBundle\Entity\Package $package
     * @return Requirement
     */
    public function setPackage(\Hal\Bundle\ReleaseBundle\Entity\Package $package = null)
    {
        $this->package = $package;
    
        return $this;
    }

    /**
     * Get package
     *
     * @return \Hal\Bundle\ReleaseBundle\Entity\Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set declaration
     *
     * @param \Hal\Bundle\ReleaseBundle\Entity\Declaration $declaration
     * @return Requirement
     */
    public function setDeclaration(\Hal\Bundle\ReleaseBundle\Entity\Declaration $declaration = null)
    {
        $this->declaration = $declaration;
    
        return $this;
    }

    /**
     * Get declaration
     *
     * @return \Hal\Bundle\ReleaseBundle\Entity\Declaration
     */
    public function getDeclaration()
    {
        return $this->declaration;
    }


    /**
     * Set requiredVersion
     *
     * @param constraint $requiredVersion
     * @return Requirement
     */
    public function setRequiredVersion($requiredVersion)
    {
        $this->requiredVersion = $requiredVersion;
    
        return $this;
    }

    /**
     * Get requiredVersion
     *
     * @return constraint 
     */
    public function getRequiredVersion()
    {
        return $this->requiredVersion;
    }
}