<?php

namespace Drupal\twig_extender_extras\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;
use Moment\Moment;

class BaseMoment extends TwigPluginBase {

  protected function getLocalMap() {

  }

  protected function getLocale() {
    $language = \Drupal::service('language_manager')->getCurrentLanguage();
    $default = 'en_GB';
    $reflector = new \ReflectionClass('\Moment\Moment');

    $lang = implode('_', [
      $language->getId(),
      strtoupper($language->getId())
    ]);

    if (!file_exists(dirname($reflector->getFileName()) . '/Locales/' . $lang . '.php')) {
      return $default;
    }
    return $lang;

  }

  protected function getDefaultTimezone() {
    return drupal_get_user_timezone();
  }

  protected function getMoment($date, $timezone = null) {
    if ($timezone === null) {
      $timezone = $this->getDefaultTimezone();
    }

    Moment::setLocale($this->getLocale());

    if ($date === null) {
      return (new Moment())->setTimezone($timezone);
    }

    if (is_numeric($date)) {
      return (new Moment())->setTimestamp($date)
                           ->setTimezone($timezone);
    }

    if (is_a($date, '\Moment\Moment')) {
      return $date;
    }

    return new Moment($date, $timezone);
  }
}