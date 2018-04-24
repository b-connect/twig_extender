<?php

namespace Drupal\twig_extender\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Cache\CacheableMetadata;

/**
 * The plugin for check authenticated user.
 *
 * @TwigPlugin(
 *   id = "twig_extender_get_block_instance",
 *   label = @Translation("Get a block instance"),
 *   type = "function",
 *   name = "block_create",
 *   function = "getBlock"
 * )
 */
class BlockCreate extends TwigPluginBase {

  /**
   * Implementation for render block.
   */
  public function getBlock($pluginId, $conf = [], $wrapper = TRUE)
  {

    $conf += ['label_display' => BlockPluginInterface::BLOCK_LABEL_VISIBLE];

    /** @var \Drupal\Core\Block\BlockPluginInterface $block_plugin */
    $block_plugin = \Drupal::service('plugin.manager.block')
      ->createInstance($pluginId, $conf);

    // Inject runtime contexts.
    if ($block_plugin instanceof ContextAwarePluginInterface) {
      $contexts = \Drupal::service('context.repository')->getRuntimeContexts($block_plugin->getContextMapping());
      \Drupal::service('context.handler')->applyContextMapping($block_plugin, $contexts);
    }

    if (!$block_plugin->access(\Drupal::currentUser())) {
      return;
    }

    $content = $block_plugin->build();

    if ($content && !Element::isEmpty($content)) {
      if ($wrapper) {
        $build = [
          '#theme' => 'block',
          '#attributes' => [],
          '#contextual_links' => [],
          '#configuration' => $block_plugin->getConfiguration(),
          '#plugin_id' => $block_plugin->getPluginId(),
          '#base_plugin_id' => $block_plugin->getBaseId(),
          '#derivative_plugin_id' => $block_plugin->getDerivativeId(),
          'content' => $content,
        ];
      } else {
        $build = $content;
      }
    } else {
      // Preserve cache metadata of empty blocks.
      $build = [
        '#markup' => '',
        '#cache' => $content['#cache'],
      ];
    }

    if (!empty($content)) {
      CacheableMetadata::createFromRenderArray($build)
        ->merge(CacheableMetadata::createFromRenderArray($content))
        ->applyTo($build);
    }

    return $build;
  }
}
