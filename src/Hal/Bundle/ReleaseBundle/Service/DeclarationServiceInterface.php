<?php

namespace Hal\Bundle\ReleaseBundle\Service;
use Hal\Bundle\ReleaseBundle\Entity\Declaration;
use Hal\Bundle\GithubBundle\Entity\Branche;


interface DeclarationServiceInterface
{


    public function refreshDeclarationFromBranche(Branche $branche);

    public function saveDeclaration(Declaration $declaration);

}
