<?php

namespace Hal\ReleaseBundle\Service;
use Hal\ReleaseBundle\Entity\Declaration;
use Hal\GithubBundle\Entity\Branche;

use Hal\ReleaseBundle\Factory\ConstraintFactory;
use Hal\ReleaseBundle\Service\PackageServiceInterface;
use Hal\ReleaseBundle\Repository\DeclarationRepositoryInterface;
use Hal\ReleaseBundle\Service\ReleaseServiceInterface;

use Hal\ReleaseBundle\Repository\RepositoryException;
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
            $requirement = new \Hal\ReleaseBundle\Entity\Requirement();
            $requirement->setRequiredVersion($constraint);
            $requirement->setPackage($package);

            // status
            $limits = $constraint->getMinAndMax();
            $release = new \Hal\ReleaseBundle\Entity\Release($limits->max);

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
