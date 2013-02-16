<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\Release;

use Behat\Gherkin\Node\TableNode;
use Hal\Bundle\GithubBundle\Entity\Branche;
use Hal\Bundle\GithubBundle\Entity\Owner;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Hal\Bundle\ReleaseBundle\Entity\Declaration;
use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Entity\Release;
use Hal\Bundle\ReleaseBundle\Entity\Requirement;
use Hal\Bundle\ReleaseBundle\Value\Constraint;
use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\PersisterAbstract;

/**
 * Persister
 */
class Persister extends PersisterAbstract
{

    public function save($object)
    {
        if (is_array($object)) {
            foreach ($object as $v) {
                $this->save($v);
            }
        } else {
            switch (true) {
                case $object instanceof Owner:
                    $this->container->get('hal.github.owner.service')->saveOwner($object);
                    return;
                    break;
                case $object instanceof Repository:
                    $this->container->get('hal.github.repository.service')->saveRepository($object);
                    return;
                    break;
                case $object instanceof Branche:
                    $this->container->get('hal.github.branche.service')->saveBranche($object);
                    break;
                case $object instanceof Package:
                    break;
                default:
                    break;
            }

            $this->em->persist($object);
            $this->em->flush();
        }
    }

    public function load($type, $value)
    {

        //
        // try to find it
        switch ($type) {
            case 'owner':
                $service = $this->container->get('hal.github.owner.service');
                $result = $service->getOwnerByLogin($value);
                break;
            case 'repository':
                $service = $this->container->get('hal.github.repository.service');
                $result = $service->getByName($value);
                break;
            case 'branche':
                $service = $this->container->get('hal.github.branche.service');
                $result = $service->getByFullName($value);
                break;
            case 'package':
                $service = $this->container->get('hal.release.package.service');
                $result = $service->getByName($value);
                break;
            case 'declaration':
                $service = $this->container->get('hal.release.package.service');
                $result = $service->getByName($value);
                break;
        }

        return $result;
    }

    public function create($type, $value)
    {
        switch ($type) {
            case 'owner':
                $object = new Owner;
                $object->setLogin($value);
                break;
            case 'repository':
                if (preg_match('!.*/(.*)!', $value, $matches)) {
                    list(, $value) = $matches;
                }
                $object = new Repository;
                $object->setName($value);
                break;
            case 'branche':
                if (preg_match('!.*/.*/(.*)!', $value, $matches)) {
                    list(, $value) = $matches;
                }
                $object = new Branche;
                $object->setName($value);
                break;
            case 'package':
                $object = new Package;
                $object->setName($value);
                break;
            case 'declaration':
                $object = new Declaration;
                $object->setName($value);
                break;
        }

        return $object;
    }

    public function loadOrCreate($type, $value)
    {
        if (is_object($value)) {
            return $value;
        }
        if ($result = $this->load($type, $value)) {
            return $result;
        }
        return $this->create($type, $value);
    }

    public function buildAttribute($object, $name, $value)
    {
        $value = parent::buildAttribute($object, $name, $value);
        switch ($name) {
            case 'version':
            case 'currentVersion':
                $value = new Release($value);
                break;
            case 'requiredVersion':
                preg_match('!([=><]+)([\d\\.]+)!', $value, $matches);
                list(, $operator, $version) = $matches;
                $value = new Constraint($version, $operator);
                break;
        }
        return $value;
    }

    // ============================================
    // ================ Repository ================
    // ============================================

    public function createRepositoriesFromTableNode(TableNode $repositories, $owner)
    {
        $repos = array();
        foreach ($repositories->getHash() as $row) {
            $repos[] = $this->createRepositoryFromArray($row, $owner);
        }
        return $repos;
    }

    public function createRepositoryFromArray(array $array, $owner)
    {
        if (preg_match('!.*/(.*)!', $array['name'], $matches)) {
            $fullName = $array['name'];
            list(, $array['name']) = $matches;
        } else {
            $fullName = implode('/', array($owner->getLogin(), $array['name']));
        }

        $repository = $this->loadOrCreate('repository', $fullName);
        $array['gitUrl'] = $array['url'] = 'abcd';
        $array['enabled'] = true;
        $this->setEntityFromArray($repository, $array);

        // owner
        $repository->setOwner($owner);
        $owner->addRepository($repository);

        // branches
        if (isset($array['branches'])) {
            $branches = explode(',', $array['branches']);
            foreach ($branches as $brancheName) {

                $name = implode('/', array($owner->getLogin(), $repository->getName(), $brancheName));
                $branche = $this->loadOrCreate('branche', $name);
                $branche->setRepository($repository)->setName($brancheName);
                $repository->addBranche($branche);
            }
        }

        $this->save($repository);
        return $repository;
    }

    // =======================================
    // ================ Owner ================
    // =======================================

    public function createOwnerFromArray(array $array)
    {
        $owner = $this->loadOrCreate('owner', $array['login']);
        $owner
                ->setName($array['login'])
                ->setLogin($array['login'])
                ->setPermanentAccessToken('abcdefgh')
                ->setUrl('http://github.com/' . $array['login'])
                ->setEmail('email@email.fr')
                ->setGravatarUrl('http://www.gravatar.com/avatar/9848efe4596436395e8d0721faa24e00.png');
        //$this->save($owner);
        return $owner;
    }

    // =======================================
    // ================ Package ==============
    // =======================================

    public function createPackageFromArray($array)
    {
        $package = $this->loadOrCreate('package', $array['name']);
        $this->setEntityFromArray($package, $array);
        //$this->save($package);
        return $package;
    }

    // =======================================
    // ================ Branch ===============
    // =======================================

    public function createBranchFromArray($array, $repository = null)
    {
        $name = $repository->getOwner()->getLogin() . '/' . $repository->getName() . '/' . $array['name'];
        $branche = $this->loadOrCreate('branche', $name);

        $array['repository'] = $repository;
        $this->setEntityFromArray($branche, $array);
        $repository->addBranche($branche);

        return $branche;
        //$this->save($branche);
    }

    // =======================================
    // ============ Requirement ==============
    // =======================================

    public function createRequirementFromArray($array, $branch)
    {
        $requirement = new Requirement();

        $branche = $this->loadOrCreate('branche', $branch);
        $package = $this->loadOrCreate('package', $array['package']);

        if ($branche->getDeclaration() != null) {
            $declaration = $branche->getDeclaration();
        } else {
            $declaration = new Declaration;
            $declaration->setBranche($branch);
            $branch->setDeclaration($declaration);
        }

        $requirement = new Requirement;
        $array = array_merge($array, array(
            'requiredVersion' => $array['requiredVersion']
            , 'package' => $package
            , 'declaration' => $declaration
                ));
        $this->setEntityFromArray($requirement, $array);

        $declaration->addRequirement($requirement);
        //$this->save($requirement);
        return $requirement;
    }

}