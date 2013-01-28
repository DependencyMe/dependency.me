<?php

namespace Hal\Bundle\ReleaseBundle\Repository;


use Doctrine\ORM\EntityManager;
use Hal\Bundle\GithubBundle\Entity\Branche;
use Hal\Bundle\ReleaseBundle\Entity\Declaration;

class DeclarationRepository implements DeclarationRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getArrayOfRequirementsFromBranche(Branche $branche)
    {
        $url = sprintf('https://raw.github.com/%1$s/%2$s/%3$s/composer.json',
            $branche->getRepository()->getOwner()->getLogin(),
            $branche->getRepository()->getName(),
            $branche->getName()
        );

        $json = @\file_get_contents($url);
        if (false === $json) {
            throw new RepositoryException('cannot find the composer.json for '.$branche->getName());
        }

        $json = json_decode($json);
        if (!isset($json->require)) {
            throw new RepositoryException('invalid composer.json : does not contain any require node');
        }


        return $json->require;
    }


    public function getOldestDeclarations($limit, \DateTime $minDate){
        $query = $this->em->createQuery("
            SELECT
                b
            FROM
                HalGithubBundle:Branche b
            JOIN
                b.repository r
            LEFT JOIN
                b.declaration d
            WHERE
                (d.lastUpdate <= :minDate
                OR d.id IS NULL)
                AND r.enabled = 1
            ORDER BY
                d.lastUpdate ASC

            ");
        $query->setParameter('minDate', $minDate);
        $query->setMaxResults($limit);
        return $query->getResult();
    }

    public function saveDeclaration(Declaration $declaration)
    {
        $this->em->persist($declaration);
        $this->em->flush();
    }
}
