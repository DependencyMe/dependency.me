<?php

namespace Hal\Bundle\ReleaseBundle\Service;

use Hal\Bundle\GithubBundle\Entity\Branche;
use Hal\Bundle\ReleaseBundle\Entity\Requirement;
use Hal\Bundle\ReleaseBundle\Repository\DeclarationRepositoryInterface;

use \Hal\Bundle\ReleaseBundle\Entity\Declaration;
use Hal\Bundle\ReleaseBundle\Entity\RequirementInterface;
use Hal\Bundle\ReleaseBundle\Factory\ConstraintFactory;


class RequirementService implements RequirementServiceInterface
{

    private $declarationRepository;

    function __construct(DeclarationRepositoryInterface $declarationRepository)
    {
        $this->declarationRepository = $declarationRepository;
    }


    public function getStateOf($elem)
    {
        switch (true) {
            case $elem instanceof Branche:
                return $this->getStateOfBranche($elem);
                break;
            case $elem instanceof Requirement:
                return $this->getStateOfRequirement($elem);
                break;
            default:
                throw new \UnexpectedValueException('Invalid requirement given. We expect a branche or a requirement object');
        }


    }

    public function getStateOfBranche(Branche $branche)
    {
        $declaration = $branche->getDeclaration();
        if (!$declaration) {
            return RequirementInterface::STATUS_UNKNOWN;
        }
        $requirements = $declaration->getRequirements();

        // not found: status is unknown
        if (sizeof($requirements) === 0) {
            return RequirementInterface::STATUS_UNKNOWN;
        }


        $status = RequirementInterface::STATUS_LATEST;
        foreach ($requirements as $requirement) {

            switch (true) {
                case $status === $requirement->getStatus():
                    continue;
                    break;

                case $status == RequirementInterface::STATUS_LATEST:
                    $status = $requirement->getStatus();
                    break;

                case $status == RequirementInterface::STATUS_RECENT
                    && $requirement->getStatus() == RequirementInterface::STATUS_OUT_OF_DATE:
                    $status = RequirementInterface::STATUS_OUT_OF_DATE;
                    break;

                case $requirement->getStatus() === RequirementInterface::STATUS_UNKNOWN:
                    $status = RequirementInterface::STATUS_UNKNOWN;
                    break 2;
            }

        }

        return $status;
    }

    public function getStateOfRequirement(Requirement $requirement)
    {
        return $requirement->getStatus();
    }


    public function refreshStateOfRequirement(Requirement $requirement)
    {

        $constraintFactory = new ConstraintFactory();

        $constraint = $constraintFactory->factory($requirement->getRequiredVersion());
        $package = $requirement->getPackage();

        if (!$constraint->isSatisfiedBy($package->getVersion())) {
            $status = RequirementInterface::STATUS_OUT_OF_DATE;
        }

        $requirement->setStatus($status);

    }
}
