<?php

namespace Hal\Bundle\GithubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Branche
 */
class Branche
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
     * @var \Hal\Bundle\GithubBundle\Entity\Repository
     */
    private $repository;


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
     * @return Branche
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
     * Set repository
     *
     * @param \Hal\Bundle\GithubBundle\Entity\Repository $repository
     * @return Branche
     */
    public function setRepository(\Hal\Bundle\GithubBundle\Entity\Repository $repository = null)
    {
        $this->repository = $repository;
    
        return $this;
    }

    /**
     * Get repository
     *
     * @return \Hal\Bundle\GithubBundle\Entity\Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }
    /**
     * @var \Hal\Bundle\ReleaseBundle\Entity\Declaration
     */
    private $declaration;


    /**
     * Set declaration
     *
     * @param \Hal\Bundle\ReleaseBundle\Entity\Declaration $declaration
     * @return Branche
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
}