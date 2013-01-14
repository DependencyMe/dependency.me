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
     * @var \Hal\GithubBundle\Entity\Branche
     */
    private $repository;

    /**
     * @var \Hal\ReleaseBundle\Entity\Package
     */
    private $package;


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
     * Set repository
     *
     * @param \Hal\GithubBundle\Entity\Branche $repository
     * @return Requirement
     */
    public function setRepository(\Hal\GithubBundle\Entity\Branche $repository = null)
    {
        $this->repository = $repository;
    
        return $this;
    }

    /**
     * Get repository
     *
     * @return \Hal\GithubBundle\Entity\Branche 
     */
    public function getRepository()
    {
        return $this->repository;
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
}
