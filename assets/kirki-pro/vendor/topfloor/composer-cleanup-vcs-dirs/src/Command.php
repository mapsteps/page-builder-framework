<?php

namespace TopFloor\ComposerCleanupVcsDirs;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand
{
  protected function configure() {
    $this->setName('cleanup-vcs-dirs');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('<info>Removing all child .git directories under the project directory</info>');

    $handler = new Handler($this->getComposer(), $this->getIO());
    $handler->cleanupVcsDirs(getcwd(), true);
  }
}
