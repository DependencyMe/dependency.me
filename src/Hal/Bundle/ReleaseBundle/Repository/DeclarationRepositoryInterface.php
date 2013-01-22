<?php

namespace Hal\Bundle\ReleaseBundle\Repository;


use Doctrine\ORM\EntityManager;
use Hal\Bundle\GithubBundle\Entity\Branche;
use Hal\Bundle\ReleaseBundle\Entity\Declaration;
interface DeclarationRepositoryInterface
{

    public function getArrayOfRequirementsFromBranche(Branche $branche);

    public function saveDeclaration(Declaration $declaration);
}
