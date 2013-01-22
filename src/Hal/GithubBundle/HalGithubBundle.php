<?php

namespace Hal\GithubBundle;
use Hal\GithubBundle\DependencyInjection\Security\Factory\GithubFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
class HalGithubBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new GithubFactory());

    }




}
