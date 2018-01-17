<?php

namespace Drupal\twig_extender_extras\Plugin\TwigPlugin;

use Drupal\Core\Render\Element;
use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;
use Moment\Moment as MomentDate;
use Drupal\Core\Site\Settings;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provide helper methods for Drupal render elements.
 *
 * @TwigPlugin(
 *   id = "twig_extender_element_moment",
 *   label = @Translation("Identifies the children of an element array, optionally sorted by weight."),
 *   type = "function",
 *   name = "moment",
 *   function = "moment"
 * )
 */
class Moment extends TwigPluginBase {

  use StringTranslationTrait;

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
  public function moment($date, $timezone = NULL) {

    $classes = Settings::get('twig_sandbox_whitelisted_classes');
    if (!in_array('twig_sandbox_whitelisted_classes', $classes)) {
      drupal_set_message($this->t('Could not use moment object. Please consult <a href="@link">README</a>',
        ['@link' => 'https://github.com/b-connect/twig_extender']
      ), 'error');
      return;
    }

    $language = \Drupal::service('language_manager')->getCurrentLanguage();
    $lang = implode('_', [
      $language->getId(),
      strtoupper($language->getId())
    ]);

    Moment::setLocale($lang);

    if ($timezone === NULL) {
      $timezone = drupal_get_user_timezone();
    }

    if (is_numeric($date)) {
      return (new MomentDate())->setTimestamp($date)
                            ->setTimezone($timezone);
    }

    return (new MomentDate($date, $timezone));
  }

}
