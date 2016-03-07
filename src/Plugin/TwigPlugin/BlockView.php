<?php

namespace Drupal\twig_extender\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;

/**
 * The plugin for check authenticated user.
 *
 *
 * @TwigPlugin(
 *   id = "twig_extender_get_block",
 *   label = @Translation("Get a block"),
 *   type = "function",
 *   name = "block_view",
 *   function = "getBlock"
 * )
 */

class BlockView extends TwigPluginBase {
  public function getBlock($block_id) {
    $block = \Drupal\block\Entity\Block::load($block_id);
    if ( !$block ) return;
    $block_content = \Drupal::entityManager()
      ->getViewBuilder('block')
      ->view($block);
    return drupal_render($block_content);
  }
}
