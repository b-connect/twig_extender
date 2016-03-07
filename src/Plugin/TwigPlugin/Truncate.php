<?php

namespace Drupal\twig_extender\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;
use Drupal\Component\Utility\Unicode;

/**
 * Example plugin for truncate
 *
 *
 * @TwigPlugin(
 *   id = "twig_extender_truncate",
 *   label = @Translation("Truncate string"),
 *   type = "filter",
 *   name = "truncate",
 *   function = "truncate"
 * )
 */

class Truncate extends TwigPluginBase {
  public function truncate($string, $max_length,$wordsafe = FALSE, $add_ellipsis = FALSE, $min_wordsafe_length = 1) {
    return Unicode::truncate($string, $max_length, $wordsafe , $add_ellipsis , $min_wordsafe_length);
  }
}
