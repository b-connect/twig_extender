<?php

namespace Drupal\twig_extender\Plugin\Twig;

use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Plugin\PluginFormInterface;

interface TwigExtensionInterface extends PluginInspectionInterface, DerivativeInspectionInterface {
    function register();
}
