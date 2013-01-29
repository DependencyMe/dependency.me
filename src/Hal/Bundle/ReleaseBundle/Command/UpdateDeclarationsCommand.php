<?php
namespace Hal\Bundle\ReleaseBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateDeclarationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('hal:release:declarations:update')
            ->setDescription('Update oldest declarations')
            ->addArgument('limit', InputArgument::REQUIRED, 'Delcarations to update by command')
            ->addArgument('maxDay', InputArgument::OPTIONAL, 'Maximal date where declarations has been updated in PHP format(now, yesterday, ...', 'yesterday');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $limit = (int)$input->getArgument('limit');
        $maxDay = new \DateTime($input->getArgument('maxDay'));
        $service = $this->getContainer()->get('hal.release.declaration.service');
        $logger = $this->getContainer()->get('logger');

        $branches = $service->getOldestDeclarations($limit, $maxDay);

        foreach ($branches as $branche) {

            $output->writeln(sprintf('updating declaration linked to the branche %s (#%d)', $branche->getName(), $branche->getId()));

            try {
                //
                // Get the declaration (infos about requirements)
                $service->refreshDeclarationFromBranche($branche);
                $service->saveDeclaration($branche->getDeclaration());
            } catch (\Exception $e) {
                $logger->err('Exception: '. $e->getMessage(). ' in '.$e->getFile());
                $output->writeln('<error>Exception: '. $e->getMessage(). ' in '.$e->getFile().'</error>');
                continue;
            }

            // log

            $logger->info(sprintf('Declaration (branche #%d) has been updated', $branche->getId()));
            $output->writeln(sprintf('<info>Declaration (branche #%d) has been updated</info>', $branche->getId()));
        }

        $output->writeln('done');
    }
}