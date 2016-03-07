<?php

namespace Drupal\twig_extender\Plugin\TwigPlugin;

use Drupal\twig_extender\Plugin\Twig\TwigPluginBase;

/**
 * The plugin for check authenticated user.
 *
 *
 * @TwigPlugin(
 *   id = "twig_extender_user_is_logged_in",
 *   label = @Translation("Check if user is logged in"),
 *   type = "function",
 *   name = "user_is_logged_in",
 *   function = "userIsLoggedIn"
 * )
 */

class UserIsLoggedIn extends TwigPluginBase {
  public function userIsLoggedIn() {
    return \Drupal::currentUser()->isAuthenticated();
  }
}
