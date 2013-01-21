<?php

namespace Hal\ReleaseBundle\Repository;


use Doctrine\ORM\EntityManager;
use Hal\GithubBundle\Entity\Branche;
use Hal\ReleaseBundle\Entity\Declaration;
interface DeclarationRepositoryInterface
{

    public function getArrayOfRequirementsFromBranche(Branche $branche);

    public function saveDeclaration(Declaration $declaration);
}
