<?php

namespace Hal\GithubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface; // for security authentication
/**
 * Owner
 */
interface OwnerInterface// extends UserInterface
{


    /**
     * Set permanentAccesToken
     *
     * @param string $permanentAccesToken
     * @return Owner
     */
    public function setPermanentAccessToken($permanentAccesToken);

    /**
     * Get permanentAccesToken
     *
     * @return string 
     */
    public function getPermanentAccessToken();
    /**
     * Set temporaryCode
     *
     * @param string $temporaryCode
     * @return Owner
     */
    public function setTemporaryCode($temporaryCode);

    /**
     * Get temporaryCode
     *
     * @return string 
     */
    public function getTemporaryCode();

}
