<?php

namespace Hal\ReleaseBundle\Service;
use Hal\ReleaseBundle\Entity\Declaration;
use Hal\GithubBundle\Entity\Branche;

use Hal\ReleaseBundle\Factory\ConstraintFactory;
use Hal\ReleaseBundle\Service\PackageServiceInterface;
use Hal\ReleaseBundle\Repository\DeclarationRepositoryInterface;

class DeclarationService implements DeclarationServiceInterface
{

    private $constraintFactory;
    private $packageService;
    private $declarationRepository;


    function __construct(DeclarationRepositoryInterface $declarationRepository,
                         ConstraintFactory $constraintFactory,
                         PackageServiceInterface $packageService)
    {
        $this->constraintFactory = $constraintFactory;
        $this->packageService = $packageService;
        $this->declarationRepository = $declarationRepository;
    }

    public function refreshDeclarationFromBranche(Branche $branche)
    {

        $requires = $this->declarationRepository->getArrayOfRequirementsFromBranche($branche);

        $declaration = $this->declarationRepository->getByBranche($branche);
        if (!$declaration) {
            $declaration = new Declaration;
        }

        foreach ($requires as $req => $version) {

            // constraint
            $constraint = $this->constraintFactory->factory($version);

            // package
            $package = $this->packageService->getOrCreateByName($req);

            // requirement
            $requirement = new \Hal\ReleaseBundle\Entity\Requirement();
            $requirement->setRequiredVersion($constraint);
            $requirement->setPackage($package);
            $package->addRequiredBy($requirement);

            $declaration->addRequirement($requirement);
            $requirement->setDeclaration($declaration);
        }

        $declaration->setBranche($branche);
        $this->saveDeclaration($declaration);
    }

    public function getByBranche(Branche $branche)
    {
        return $this->declarationRepository->getByBranche($branche);
    }

    public function saveDeclaration(Declaration $declaration)
    {
        $this->declarationRepository->saveDeclaration($declaration);
    }
}
