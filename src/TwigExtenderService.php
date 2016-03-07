<?php

namespace Drupal\twig_extender;

use Drupal\Core\Template\TwigExtension;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Validation\DrupalTranslator;

class TwigExtenderService extends TwigExtension {

  public function __construct(RendererInterface $renderer) {
    parent::__construct($renderer);
    $this->renderer = $renderer;
    $this->translator = new DrupalTranslator();
    $this->pluginManager = \Drupal::service('plugin.manager.twig_extender');
    $this->plugins = $this->pluginManager->getDefinitions();
  }

  public function getFunctions() {
    $functions = parent::getFunctions() ;
    foreach ( $this->plugins as  $id => $plugin ) {
      $plugin = $this->pluginManager->createInstance($id,$plugin);
      if ( $plugin->getType() != 'function' ) continue;
      $functions[] = $plugin->register();
    }
    return $functions;
  }

  public function getFilters() {
    $filters = parent::getFilters() ;
    foreach ( $this->plugins as  $id => $plugin ) {
      $plugin = $this->pluginManager->createInstance($id);
      if ( $plugin->getType() != 'filter' ) continue;
      $filters[] = $plugin->register();
    }
    return $filters;
  }

}
