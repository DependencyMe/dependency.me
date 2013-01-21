<?php

namespace Hal\ReleaseBundle\Repository;


use Doctrine\ORM\EntityManager;
use Hal\GithubBundle\Entity\Branche;
use Hal\ReleaseBundle\Entity\Declaration;

class DeclarationRepository implements DeclarationRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getArrayOfRequirementsFromBranche(Branche $branche)
    {
        $url = $branche->getRepository()->getUrl();
        $url = sprintf('https://raw.github.com/%1$s/%2$s/%3$s/composer.json',
            $branche->getRepository()->getOwner()->getLogin(),
            $branche->getRepository()->getName(),
            strtolower($branche->getName())
        );

        $json = \file_get_contents($url);
        if (false === $json) {
            throw new RepositoryException('cannot find the composer.json');
        }

        $json = json_decode($json);
        if (!isset($json->require)) {
            throw new RepositoryException('invalid composer.json : does not contain any require node');
        }


        return $json->require;
    }

    public function saveDeclaration(Declaration $declaration)
    {
        $this->em->persist($declaration);
        $this->em->flush();
    }
}
