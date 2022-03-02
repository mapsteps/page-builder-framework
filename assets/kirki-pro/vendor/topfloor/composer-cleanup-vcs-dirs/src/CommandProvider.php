<?php

namespace TopFloor\ComposerCleanupVcsDirs;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Composer\Command\BaseCommand;

class CommandProvider implements CommandProviderCapability
{

  /**
   * Retreives an array of commands
   *
   * @return BaseCommand[]
   */
  public function getCommands() {
    return [
      new Command
    ];
  }
}
