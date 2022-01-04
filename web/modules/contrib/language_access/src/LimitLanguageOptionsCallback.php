<?php

namespace Drupal\language_access;

use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Class LimitLanguageOptionsCallback.
 *
 * @package Drupal\language_access
 */
class LimitLanguageOptionsCallback implements TrustedCallbackInterface {

  /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks() {
    return ['preRender'];
  }

  /**
   * Alters the language widget options.
   *
   * Limits the options to those that the user is allowed to access.
   *
   * @param array $element
   *   The language form element.
   *
   * @return array
   *   The language form element.
   */
  public static function preRender(array $element): array {
    $languages = \Drupal::languageManager()->getLanguages();
    foreach ($element['#options'] as $id => $description) {
      if (isset($languages[$id]) && !$element['#for_user']->hasPermission('access language ' . $id)) {
        unset($element['#options'][$id]);
      }
    }
    unset($element['#for_user']);
    return $element;
  }

}
