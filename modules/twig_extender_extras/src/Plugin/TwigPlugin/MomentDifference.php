<?php

namespace Drupal\twig_extender_extras\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;

/**
 * Provide helper methods for Drupal render elements.
 *
 * @TwigPlugin(
 *   id = "twig_extender_moment_difference",
 *   label = @Translation("Identifies the children of an element array, optionally sorted by weight."),
 *   type = "filter",
 *   name = "moment_difference",
 *   function = "moment"
 * )
 */
class MomentDifference extends BaseMoment {

  /**
   * Identifies the children of an element array, optionally sorted by weight.
   *
   * The children of a element array are those key/value pairs whose key does
   * not start with a '#'. See drupal_render() for details.
   *
   * @param array $elements
   *   The element array whose children are to be identified. Passed by
   *   reference.
   * @param bool $sort
   *   Boolean to indicate whether the children should be sorted by weight.
   *
   * @return array
   *   The filtered array to loop over.
   * @throws \Exception
   */
  public function moment($from, $to = null, $operation = 'direction', $timezone = NULL) {
    $moment = $this->getMoment($to, $timezone);
    $from = $this->getMoment($from, $timezone);
    $funcCall = 'get' . ucfirst($operation);
    return $moment->from($from->format())->$funcCall();
  }

}
