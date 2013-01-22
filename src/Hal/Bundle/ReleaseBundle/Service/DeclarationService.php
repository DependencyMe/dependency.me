<?php

namespace Hal\Bundle\ReleaseBundle\Service;
use Hal\Bundle\ReleaseBundle\Entity\Declaration;
use Hal\Bundle\GithubBundle\Entity\Branche;

use Hal\Bundle\ReleaseBundle\Factory\ConstraintFactory;
use Hal\Bundle\ReleaseBundle\Service\PackageServiceInterface;
use Hal\Bundle\ReleaseBundle\Repository\DeclarationRepositoryInterface;
use Hal\Bundle\ReleaseBundle\Service\ReleaseServiceInterface;

use Hal\Bundle\ReleaseBundle\Repository\RepositoryException;
class DeclarationService implements DeclarationServiceInterface
{

    private $constraintFactory;
    private $packageService;
    private $declarationRepository;
    private $releaseService;


    function __construct(DeclarationRepositoryInterface $declarationRepository,
                         ConstraintFactory $constraintFactory,
                         PackageServiceInterface $packageService,
                         ReleaseServiceInterface $releaseService
    )
    {
        $this->constraintFactory = $constraintFactory;
        $this->packageService = $packageService;
        $this->declarationRepository = $declarationRepository;
        $this->releaseService = $releaseService;
    }

    public function refreshDeclarationFromBranche(Branche $branche)
    {

        try {
            $requires = $this->declarationRepository->getArrayOfRequirementsFromBranche($branche);
            $declaration = $branche->getDeclaration();
            if (!$declaration) {
                $declaration = new Declaration;
            }
        } catch (RepositoryException $e) {
            $declaration = new Declaration;
            $requires = array();
        }

        // remove old informations
        foreach ($declaration->getRequirements() as $req) {
            $declaration->removeRequirement($req);
        }

        foreach ($requires as $req => $version) {

            // excludes system's dependencies
            if(preg_match('!^(lib|ext)\-!', $req) || $req == 'php') {
                continue;
            }

            // constraint
            $constraint = $this->constraintFactory->factory($version);

            // package
            $package = $this->packageService->getOrCreateByName($req);

            // requirement
            $requirement = new \Hal\Bundle\ReleaseBundle\Entity\Requirement();
            $requirement->setRequiredVersion($constraint);
            $requirement->setPackage($package);

            // status
            $limits = $constraint->getMinAndMax();
            $release = new \Hal\Bundle\ReleaseBundle\Entity\Release($limits->max);

            $state = $this->releaseService->getStateOf($release, $package->getCurrentVersion());
            $requirement->setStatus($state);


            $package->addRequiredBy($requirement);

            $declaration->addRequirement($requirement);
            $requirement->setDeclaration($declaration);
        }

        $declaration->setBranche($branche);
        $branche->setDeclaration($declaration);
        $this->saveDeclaration($declaration);
    }

    public function saveDeclaration(Declaration $declaration)
    {
        $this->declarationRepository->saveDeclaration($declaration);
    }
}
