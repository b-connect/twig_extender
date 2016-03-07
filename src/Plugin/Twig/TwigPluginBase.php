<?php

/**
 * @file
 * Contains \Drupal\twig_extender\Plugin\Twig\TwigPluginBase.
 */

namespace Drupal\twig_extender\Plugin\Twig;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\twig_extender\Plugin\Twig\TwigExtensionInterface;

/**
 * Provides a base class for Twig plugins plugins.
 */
class TwigPluginBase extends PluginBase implements TwigExtensionInterface  {

  public function getType() {
    return $this->pluginDefinition['type'];
  }

  public function getName() {
    return $this->pluginDefinition['name'];
  }

  public function getFunction() {
    return $this->pluginDefinition['function'];
  }

  public function register() {
    if ( $this->getType() == 'function' ) {
      return new \Twig_SimpleFunction($this->getName(), array($this, $this->getFunction()));
    } else {
      return new \Twig_SimpleFilter($this->getName(), array($this, $this->getFunction()));
    }
  }
}
