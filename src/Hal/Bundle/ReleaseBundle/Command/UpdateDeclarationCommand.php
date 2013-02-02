<?php

namespace Hal\Bundle\ReleaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateDeclarationCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('hal:release:declaration:update')
            ->setDescription('Update one declaration')
            ->addArgument('name', InputArgument::REQUIRED, 'ex: Halleck45/BehatWizardBundle');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $serviceRepo = $this->getContainer()->get('hal.github.repository.service');
        $serviceDecl = $this->getContainer()->get('hal.release.declaration.service');

        $repository = $serviceRepo->getByName($input->getArgument('name'));
        if(!$repository) {
            throw new \Exception('repository not found');
        }
        $branches = $repository->getBranches();

        $logger = $this->getContainer()->get('logger');

        $output->writeln(sprintf('<info>updating %s</info>', $repository->getName()));


        foreach ($branches as $branche) {


            $output->writeln(sprintf('updating declaration linked to the branche %s (#%d)', $branche->getName(), $branche->getId()));

            try {
                //
                // Get the declaration (infos about requirements)
                $serviceDecl->refreshDeclarationFromBranche($branche);
                $serviceDecl->saveDeclaration($branche->getDeclaration());
            } catch (\Exception $e) {
                $logger->err('Exception: ' . $e->getMessage() . ' in ' . $e->getFile());
                $output->writeln('<error>Exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ' at ' . $e->getLine() . '</error>');
                continue;
            }

            // log

            $logger->info(sprintf('Declaration (branche #%d) has been updated', $branche->getId()));
            $output->writeln(sprintf('<info>Declaration (branche #%d) has been updated</info>', $branche->getId()));
        }

        $output->writeln('done');
    }

}