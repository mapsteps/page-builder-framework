<?php

namespace TopFloor\ComposerCleanupVcsDirs;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvent;
use Composer\Plugin\Capable;

/**
 * Class Plugin
 * @package TopFloor\ComposerCleanupVcsDirs
 */
class Plugin implements PluginInterface, EventSubscriberInterface, Capable {
  /**
   * @var \TopFloor\ComposerCleanupVcsDirs\Handler
   */
  protected $handler;

  /**
   * Returns an array of event names this subscriber wants to listen to.
   *
   * The array keys are event names and the value can be:
   *
   * * The method name to call (priority defaults to 0)
   * * An array composed of the method name to call and the priority
   * * An array of arrays composed of the method names to call and respective
   *   priorities, or 0 if unset
   *
   * For instance:
   *
   * * array('eventName' => 'methodName')
   * * array('eventName' => array('methodName', $priority))
   * * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
   *
   * @return array The event names to listen to
   */
  public static function getSubscribedEvents() {
    return [
      PackageEvents::POST_PACKAGE_INSTALL => 'postPackageInstall',
      PackageEvents::POST_PACKAGE_UPDATE => 'postPackageUpdate',
    ];
  }

  /**
   * Method by which a Plugin announces its API implementations, through an array
   * with a special structure.
   *
   * The key must be a string, representing a fully qualified class/interface name
   * which Composer Plugin API exposes.
   * The value must be a string as well, representing the fully qualified class name
   * of the implementing class.
   *
   * @tutorial
   *
   * return array(
   *     'Composer\Plugin\Capability\CommandProvider' => 'My\CommandProvider',
   *     'Composer\Plugin\Capability\Validator'       => 'My\Validator',
   * );
   *
   * @return string[]
   */
  public function getCapabilities() {
    return [
      'Composer\Plugin\Capability\CommandProvider' => 'TopFloor\ComposerCleanupVcsDirs\CommandProvider'
    ];
  }

  /**
   * Apply plugin modifications to Composer
   *
   * @param Composer $composer
   * @param IOInterface $io
   */
  public function activate(Composer $composer, IOInterface $io) {
    $this->handler = new Handler($composer, $io);
  }

  /**
   * Deactivation hook.
   *
   * @param Composer $composer
   * @param IOInterface $io
   */
  public function deactivate(Composer $composer, IOInterface $io) {
  }

  /**
   * Uninstall hook.
   *
   * @param Composer $composer
   * @param IOInterface $io
   */
  public function uninstall(Composer $composer, IOInterface $io) {
  }

  /**
   * @param \Composer\Installer\PackageEvent $event
   */
  public function postPackageInstall(PackageEvent $event) {
    $package = $event->getOperation()->getPackage();

    $this->handler->onPostPackageEvent($package);
  }

  /**
   * @param \Composer\Installer\PackageEvent $event
   */
  public function postPackageUpdate(PackageEvent $event) {
    $package = $event->getOperation()->getInitialPackage();

    $this->handler->onPostPackageEvent($package);
  }
}
