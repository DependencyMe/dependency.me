<?php
namespace Hal\GithubBundle\Entity;

class Authentifiable implements AuthentifiableInterface {


    private $permanentAccessToken;
    private $temporaryCode;

    public function setPermanentAccessToken($permanentAccessToken)
    {
        $this->permanentAccessToken = $permanentAccessToken;
    }

    public function getPermanentAccessToken()
    {
        return $this->permanentAccessToken;
    }

    public function setTemporaryCode($temporaryCode)
    {
        $this->temporaryCode = $temporaryCode;
    }

    public function getTemporaryCode()
    {
        return $this->temporaryCode;
    }
}