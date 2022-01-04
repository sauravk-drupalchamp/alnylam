<?php

namespace Drupal\Tests\language_access\Functional;

use Drupal\language\Entity\ConfigurableLanguage;
use Drupal\language\Entity\ContentLanguageSettings;
use Drupal\Tests\BrowserTestBase;

/**
 * Class LanguageAccessTestBase.
 *
 * @group language_access
 *
 * @package Drupal\Tests\language_access\Functional
 */
abstract class LanguageAccessTestBase extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'language_access',
    'node',
    'image',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * The role storage.
   *
   * @var \Drupal\user\RoleStorage
   */
  protected $roleStorage;

  /**
   * A user entity that has access to the EN language.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $userEn;

  /**
   * A user entity that has access to the NL language.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $userNl;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $this->drupalCreateContentType(['type' => 'page']);
    $this->config('system.site')->set('page.front', '/node')->save();

    // Create NL language.
    ConfigurableLanguage::createFromLangcode('nl')->save();

    // Set the language path prefixes.
    $this->config('language.negotiation')->set('url', [
      'source' => 'path_prefix',
      'prefixes' => [
        'en' => 'en',
        'nl' => 'nl',
      ],
    ])->save();

    // Turn on content translation for pages.
    $config = ContentLanguageSettings::loadByEntityTypeBundle('node', 'page');
    $config->setDefaultLangcode('en')
      ->setLanguageAlterable(TRUE)
      ->save();

    $this->drupalCreateNode(['type' => 'page']);

    // Access to the default language.
    $this->roleStorage = $this->container->get('entity_type.manager')->getStorage('user_role');
    $authenticated_role = $this->roleStorage->load('authenticated');
    $authenticated_role->revokePermission('access language en');
    $authenticated_role->save();

    $this->userEn = $this->createUser(['access language en']);
    $this->userNl = $this->createUser(['access language nl']);
  }

}
