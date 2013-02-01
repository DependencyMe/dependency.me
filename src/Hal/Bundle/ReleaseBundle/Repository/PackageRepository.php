<?php

namespace Hal\Bundle\ReleaseBundle\Repository;

use Doctrine\ORM\EntityManager;
use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Repository\Package\NotFoundException;
use Hal\Bundle\ReleaseBundle\Repository\Package\InfoMissingException;
use Hal\Bundle\ReleaseBundle\Factory\ConstraintFactory;

class PackageRepository implements PackageRepositoryInterface
{

    private $em;
    private $constraintFactory;

    public function __construct(EntityManager $em, ConstraintFactory $constraintFactory)
    {
        $this->em = $em;
        $this->constraintFactory = $constraintFactory;
    }

    public function getByName($name)
    {
        $query = $this->em->createQuery("
            SELECT
                p
            FROM
                HalReleaseBundle:Package p
            WHERE
                p.name = :name
            ");
        $query->setParameter('name', $name);
        return $query->getOneOrNullResult();
    }

    public function savePackage(Package $package)
    {
        $this->em->persist($package);
        $this->em->flush();
    }

    public function getOldestPackages($limit, \DateTime $minDate)
    {
        $query = $this->em->createQuery("
            SELECT
                p
            FROM
                HalReleaseBundle:Package p
            WHERE
                p.lastUpdate <= :minDate
            ORDER BY
                p.lastUpdate ASC

            ");
        $query->setParameter('minDate', $minDate);
        $query->setMaxResults($limit);
        return $query->getResult();
    }

    public function getInfosOfPackage(Package $package)
    {

        $parsers = array(
            new \Hal\Bundle\ReleaseBundle\Repository\Package\Parser\ParserPackagistRss($package, sprintf('https://packagist.org/feeds/package.%s.rss', $package->getName()))
            , new \Hal\Bundle\ReleaseBundle\Repository\Package\Parser\ParserPackagistHtml($package, sprintf('https://packagist.org/packages/%s', $package->getName()))
        );

        foreach ($parsers as $url => $parser) {
            try {
                $parser->parse();
                if (null !== $parser->getLastVersion()) {
                    break;
                }
            } catch (NotFoundException $e) {

            } catch (InfoMissingException $e) {
                continue;
            }
        }

        return (object) array(
                'url' => $parser->getUrl(),
                'releaseDate' => $parser->getReleaseDate(),
                'version' => $parser->getLastVersion(),
                'author' => $parser->getAuthor()
        );
    }

}
