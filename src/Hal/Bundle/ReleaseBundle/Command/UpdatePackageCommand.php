<?php

namespace Hal\Bundle\ReleaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdatePackageCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('hal:release:package:update')
            ->setDescription('Update one package')
            ->addArgument('name', InputArgument::REQUIRED, 'Package to update')
            ->addOption('force');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $service = $this->getContainer()->get('hal.release.package.service');
        $logger = $this->getContainer()->get('logger');

        $package = $service->getOrCreateByName($input->getArgument('name'));

        if (!$package->getId() && !$input->getOption('force') ) {
            $output->writeln('<error>Package not found and doesnt exist. Please use --force</error>');
            return;
        }

        $output->writeln(sprintf('updating package %s', $package->getName()));

        try {
            //
            // Get the declaration (infos about requirements)
            $service->refreshPackage($package);
            $service->savePackage($package);
        } catch (\Exception $e) {
            $logger->err('Exception: ' . $e->getMessage());
            $output->writeln('<error>Exception: ' . $e->getMessage() . '</error>');
        }

        // log

        $logger->info(sprintf('Package %s has been updated', $package->getName()));
        $output->writeln(sprintf('<info>Package %s has been updated</info>', $package->getName()));

        $output->writeln('done');
    }

}