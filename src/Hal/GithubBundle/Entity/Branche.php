<?php

namespace Hal\GithubBundle\Entity;

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
     * @var \Hal\GithubBundle\Entity\Repository
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
     * @param \Hal\GithubBundle\Entity\Repository $repository
     * @return Branche
     */
    public function setRepository(\Hal\GithubBundle\Entity\Repository $repository = null)
    {
        $this->repository = $repository;
    
        return $this;
    }

    /**
     * Get repository
     *
     * @return \Hal\GithubBundle\Entity\Repository 
     */
    public function getRepository()
    {
        return $this->repository;
    }
}