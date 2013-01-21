<?php

namespace Hal\ReleaseBundle\Service;
use Hal\ReleaseBundle\Entity\Declaration;
use Hal\GithubBundle\Entity\Branche;


interface DeclarationServiceInterface
{


    public function refreshDeclarationFromBranche(Branche $branche);

    public function saveDeclaration(Declaration $declaration);

}
