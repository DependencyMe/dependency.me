<?php

namespace Hal\ReleaseBundle\Entity;

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
     * @var \Hal\ReleaseBundle\Entity\Package
     */
    private $package;

    /**
     * @var \Hal\ReleaseBundle\Entity\Declaration
     */
    private $declaration;


    public function __construct() {
        $this->requiredVersion = new \Hal\ReleaseBundle\Value\Constraint('*','=');
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
     * @param \Hal\ReleaseBundle\Entity\Package $package
     * @return Requirement
     */
    public function setPackage(\Hal\ReleaseBundle\Entity\Package $package = null)
    {
        $this->package = $package;
    
        return $this;
    }

    /**
     * Get package
     *
     * @return \Hal\ReleaseBundle\Entity\Package 
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set declaration
     *
     * @param \Hal\ReleaseBundle\Entity\Declaration $declaration
     * @return Requirement
     */
    public function setDeclaration(\Hal\ReleaseBundle\Entity\Declaration $declaration = null)
    {
        $this->declaration = $declaration;
    
        return $this;
    }

    /**
     * Get declaration
     *
     * @return \Hal\ReleaseBundle\Entity\Declaration 
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