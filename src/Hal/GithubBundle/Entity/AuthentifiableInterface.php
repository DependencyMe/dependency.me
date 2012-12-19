<?php
namespace Hal\GithubBundle\Entity;

interface AuthentifiableInterface {

    public function setPermanentAccessToken($permanentAccessToken);

    public function getPermanentAccessToken();

    public function setTemporaryCode($temporaryCode);

    public function getTemporaryCode();

}