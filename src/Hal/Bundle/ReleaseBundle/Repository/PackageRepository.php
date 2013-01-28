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

        // RSS of packagist
        $url = sprintf('https://packagist.org/feeds/package.%s.rss', $package->getName());
        $content = @file_get_contents($url);
        if (false === $content) {
            throw new NotFoundException("Package {$package->getName()} not found on packagist");
        }

        $xml = new \SimpleXMLElement($content);
        $info = $xml->channel->item[0];

        if (!isset($info->title)) {
            // not found in RSS
            // we will try to use the html page :-/ (example: symfony/yaml is not visible in the RSS)
            $url = sprintf('https://packagist.org/packages/%s', $package->getName());
            $content = @file_get_contents($url);
            if (false === $content) {
                throw new NotFoundException("Package {$package->getName()} not found on packagist (version html)");
            }

            $version = '';
            if (preg_match(sprintf('!https://github.com/%s/tree/([\\w\\d\\.\\-]*)"!i', $package->getName()), $content, $matches)) {
                $version = $matches[1];
            } else if (preg_match(sprintf('!value="&quot;%s&quot;: &quot;(.*)&quot;"!', $package->getName()), $content, $matches)) {
                $version = $matches[1];
            }
            $version = preg_replace('!(@.*)$!', '', $version);
            $version = preg_replace('!\\.\\*$!', '', $version);


            if (strlen($version) > 0) {
                $release = new \Hal\Bundle\ReleaseBundle\Entity\Release($version);
                return (object)array(
                    'url' => null,
                    'releaseDate' => null,
                    'version' => $release,
                    'author' => null
                );

            } else {
                throw new InfoMissingException("No information found for '{$package->getName()}' at '$url' (html and rss)");
            }

        } else {

            // found in the rss
            if (!preg_match('!\\((.*)\\)!', $info->title, $matches)) {
                throw new InfoMissingException("Package {$package->getName()} : cannot parse the given version ($info->title)");
            }
            $v = preg_replace('!^v!', '', $matches[1]);
            $release = new \Hal\Bundle\ReleaseBundle\Entity\Release($v);
        }


        return (object)array(
            'url' => $info->link,
            'releaseDate' => new \DateTime($info->pubDate),
            'version' => $release,
            'author' => $info->author
        );
    }


}
