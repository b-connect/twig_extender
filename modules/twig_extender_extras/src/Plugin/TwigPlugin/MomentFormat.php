<?php

namespace Drupal\twig_extender_extras\Plugin\TwigPlugin;

use Drupal\Core\Render\Element;
use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;
use Moment\Moment;

/**
 * Provide helper methods for Drupal render elements.
 *
 * @TwigPlugin(
 *   id = "twig_extender_moment_format",
 *   label = @Translation("Identifies the children of an element array, optionally sorted by weight."),
 *   type = "filter",
 *   name = "moment_format",
 *   function = "moment"
 * )
 */
class MomentFormat extends TwigPluginBase {

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
  public function moment($date, $format, $timezone = NULL) {

    $language = \Drupal::service('language_manager')->getCurrentLanguage();
    $lang = implode('_', [
      $language->getId(),
      strtoupper($language->getId())
    ]);
    Moment::setLocale($lang);

    if ($timezone === NULL) {
      $timezone = drupal_get_user_timezone();
    }

    $build = [
      '#cache' => [
        'contexts' => ['languages', 'timezone']
      ]
    ];

    if (is_numeric($date)) {
      $value = (new Moment())->setTimestamp($date)
                            ->setTimezone($timezone)
                            ->format($format);
      $build['#markup'] = $value;
      return $build;
    }
    $value = (new Moment($date, $timezone))->format($format);
    $build['#markup'] = $value;
    return $build;
  }

}
