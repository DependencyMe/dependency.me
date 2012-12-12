<?php

namespace Hal\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PackageController extends Controller
{
    /**
     * @Template(vars={$package})
     */
    public function displayPackageAction(\Hal\ReleaseBundle\Entity\Package $package)
    {
    }
}
