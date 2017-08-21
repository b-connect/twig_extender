<?php

namespace Drupal\twig_extender\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;
use Drupal\Core\Entity;

/**
 * The plugin for check authenticated user.
 *
 * @TwigPlugin(
 *   id = "twig_extender_is_front",
 *   label = @Translation("Check if is on frontpage"),
 *   type = "function",
 *   name = "is_front",
 *   function = "isFront"
 * )
 */
class IsFront extends TwigPluginBase {

  /**
   * Implementation for render block.
   */
  public function isFront() {
    return \Drupal::service('path.matcher')->isFrontPage();
  }

}
