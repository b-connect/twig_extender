<?php

namespace Drupal\twig_extender\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;
use Drupal\Core\Entity;

/**
 * The plugin for render a url string of url object or ContentEntityBase object.
 *
 * @TwigPlugin(
 *   id = "twig_extender_to_url",
 *   label = @Translation("Get path alias by path"),
 *   type = "filter",
 *   name = "to_url",
 *   function = "toUrl"
 * )
 */
class ToUrl extends TwigPluginBase {

  /**
   * Implementation for render block.
   */
  public function toUrl($url, $absolute = false) {

    if (is_a($url, \Drupal\Core\Entity\ContentEntityBase::class)) {
      $url = $url->toUrl();
    }
    if (is_a($url, 'Drupal\Core\Url')) {
      $url = $url->toString();
    }
    if (gettype($url) !== 'string') {
      throw new \Exception('Could not convert object to a path alias');
    }
    return \Drupal::service('path.alias_manager')->getAliasByPath($url);
  }

}
