<?php
namespace Hal\Bundle\ReleaseBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdatePackagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('hal:release:packages:update')
            ->setDescription('Update oldest packages')
            ->addArgument('limit', InputArgument::REQUIRED, 'Packages to update')
            ->addArgument('maxDay', InputArgument::OPTIONAL, 'Maximal date where Packages has been updated in PHP format(now, yesterday, ...', 'yesterday');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $limit = (int)$input->getArgument('limit');
        $maxDay = new \DateTime($input->getArgument('maxDay'));
        $service = $this->getContainer()->get('hal.release.package.service');
        $logger = $this->getContainer()->get('logger');

        $packages = $service->getOldestPackages($limit, $maxDay);

        foreach ($packages as $package) {

            $output->writeln(sprintf('updating package %s', $package->getName()));

            try {
                //
                // Get the declaration (infos about requirements)
                $service->refreshPackage($package);
                $service->savePackage($package);
            } catch (\Exception $e) {
                $logger->err('Exception: '. $e->getMessage());
                $output->writeln('<error>Exception: '. $e->getMessage().'</error>');
                continue;
            }

            // log

            $logger->info(sprintf('Package %s has been updated', $package->getName()));
            $output->writeln(sprintf('<info>Package %s has been updated</info>', $package->getName()));
        }

        $output->writeln('done');
    }
}