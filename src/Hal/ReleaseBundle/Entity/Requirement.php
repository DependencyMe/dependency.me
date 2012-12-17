<?php

namespace Hal\ReleaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requirement
 */
class Requirement
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var constraint
     */
    private $constraint;

    /**
     * @var requirementstatus
     */
    private $status;

    /**
     * @var \Hal\ReleaseBundle\Entity\Package
     */
    private $package;

    /**
     * @var \Hal\ReleaseBundle\Entity\Package
     */
    private $packageExpected;


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
     * Set constraint
     *
     * @param constraint $constraint
     * @return Requirement
     */
    public function setConstraint($constraint)
    {
        $this->constraint = $constraint;
    
        return $this;
    }

    /**
     * Get constraint
     *
     * @return constraint 
     */
    public function getConstraint()
    {
        return $this->constraint;
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
     * Set packageExpected
     *
     * @param \Hal\ReleaseBundle\Entity\Package $packageExpected
     * @return Requirement
     */
    public function setPackageExpected(\Hal\ReleaseBundle\Entity\Package $packageExpected = null)
    {
        $this->packageExpected = $packageExpected;
    
        return $this;
    }

    /**
     * Get packageExpected
     *
     * @return \Hal\ReleaseBundle\Entity\Package 
     */
    public function getPackageExpected()
    {
        return $this->packageExpected;
    }
}
