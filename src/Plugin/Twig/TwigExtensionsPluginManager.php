<?php

/**
 * @file
 * Contains \Drupal\twig_extender\Plugin\Twig\TwigExtensionsPluginManager.
 */

namespace Drupal\twig_extender\Plugin\Twig;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Plugin\Discovery\YamlDiscoveryDecorator;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\twig_extender\Plugin\Twig\TwigPluginManagerInterface;

/**
 * Plugin type manager for all twig plugins.
 */
class TwigExtensionsPluginManager extends DefaultPluginManager implements TwigPluginManagerInterface {

  /**
   * Constructs a TwigExtensionsPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handle to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, ThemeHandlerInterface $theme_handler) {
    $plugin_interface = 'Drupal\twig_extender\Plugin\Twig\TwigExtensionInterface';
    $plugin_definition_annotation_name = 'Drupal\twig_extender\Annotation\TwigPlugin';
    parent::__construct("Plugin/TwigPlugin", $namespaces, $module_handler, $plugin_interface, $plugin_definition_annotation_name);
    $discovery = $this->getDiscovery();
    $this->discovery = new YamlDiscoveryDecorator($discovery, 'twigplugins', $module_handler->getModuleDirectories() + $theme_handler->getThemeDirectories());
    $this->themeHandler = $theme_handler;
    $this->moduleHandler = $module_handler;
    $this->setCacheBackend($cache_backend, 'twig_extender');
    $this->defaults += array(
      'class' => 'Drupal\twig_extender\Plugin\Twig\TwigPluginBase',
    );
    $this->alterInfo('twig_extender');
  }

  /**
   * {@inheritdoc}
   */
  protected function providerExists($provider) {
    return $this->moduleHandler->moduleExists($provider) || $this->themeHandler->themeExists($provider);
  }

  /**
   * {@inheritdoc}
   */
  public function processDefinition(&$definition, $plugin_id) {
    parent::processDefinition($definition, $plugin_id);

    // Add the module or theme path to the 'path'.
    if ($this->moduleHandler->moduleExists($definition['provider'])) {
      $definition['provider_type'] = 'module';
      $base_path = $this->moduleHandler->getModule($definition['provider'])->getPath();
    }
    elseif ($this->themeHandler->themeExists($definition['provider'])) {
      $definition['provider_type'] = 'theme';
      $base_path = $this->themeHandler->getTheme($definition['provider'])->getPath();
    }
    else {
      $base_path = '';
    }

  }

}
