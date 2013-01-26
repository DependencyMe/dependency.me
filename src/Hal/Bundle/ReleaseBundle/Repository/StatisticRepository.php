<?php
namespace Hal\Bundle\ReleaseBundle\Repository;

use Hal\Bundle\ReleaseBundle\Repository\StatisticRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Hal\Bundle\ReleaseBundle\Entity\RequirementInterface;

/**
 * Allows to retrieve and save Statistic
 *
 * @author Jean-François Lépine
 * @implements RepositoryStatisticInterface
 */
class StatisticRepository implements StatisticRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getRegisteredSum()
    {

        $sql = 'SELECT '
            . sprintf('(SELECT COUNT(*) FROM %s WHERE %s = 1) as nbRepositories', $this->em->getClassMetadata('HalGithubBundle:Repository')->getTableName(), $this->em->getClassMetadata('HalGithubBundle:Repository')->getColumnName('enabled'))
            . sprintf(',(SELECT COUNT(*) FROM %s )  as nbBranches', $this->em->getClassMetadata('HalGithubBundle:Branche')->getTableName())
            . sprintf(',(SELECT COUNT(*) FROM %s) as nbOwners ', $this->em->getClassMetadata('HalGithubBundle:Owner')->getTableName())
            . '';

        $statuts = array(
            'OutOfDate' => RequirementInterface::STATUS_OUT_OF_DATE,
            'Recent' => RequirementInterface::STATUS_RECENT,
            'Latest' => RequirementInterface::STATUS_LATEST,
            'Unknown' => RequirementInterface::STATUS_UNKNOWN,
            'Dev' => RequirementInterface::STATUS_DEV
        );
        foreach ($statuts as $name => $statut) {
            $sql .= sprintf(', (SELECT COUNT(*) FROM %1$s WHERE %2$s = %3$s'
                , $this->em->getClassMetadata('HalReleaseBundle:Requirement')->getTableName()
                , $this->em->getClassMetadata('HalGithubBundle:Owner')->getColumnName('status')
                , $this->em->getConnection()->quote($statut)
            )
                . ') as nbRequirementsStatus' . $name
                . '';
        }

        return $this->em->getConnection()->fetchAssoc($sql);
    }

}