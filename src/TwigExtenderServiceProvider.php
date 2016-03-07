<?php
/**
 * @file
 * Contains Drupal\my_module\MyModuleServiceProvider
 */

namespace Drupal\twig_extender;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Modifies the language manager service.
 */
class TwigExtenderServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Overrides language_manager class to test domain language negotiation.
    $definition = $container->getDefinition('twig.extension');
    $definition->setClass('\Drupal\twig_extender\TwigExtenderService');
  }
}
