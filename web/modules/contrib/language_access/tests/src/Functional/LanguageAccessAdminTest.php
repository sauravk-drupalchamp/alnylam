<?php

namespace Drupal\Tests\language_access\Functional;

use Drupal\language\Entity\ContentLanguageSettings;

/**
 * Class LanguageAccessAdminTest.
 *
 * @group language_access
 *
 * @package Drupal\Tests\language_access\Functional
 */
class LanguageAccessAdminTest extends LanguageAccessTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'taxonomy',
    'user',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $this->container->get('entity_type.manager')
      ->getStorage('taxonomy_vocabulary')
      ->create([
        'vid' => 'tags',
        'name' => 'Tags',
      ])->save();

    $config = ContentLanguageSettings::loadByEntityTypeBundle('taxonomy_term', 'tags');
    $config->setDefaultLangcode('en')
      ->setLanguageAlterable(TRUE)
      ->save();

    $role_id = $this->drupalCreateRole([
      'create page content',
      'create terms in tags',
      'administer users',
    ]);
    $this->userEn->addRole($role_id);
    $this->userEn->save();
    $this->userNl->addRole($role_id);
    $this->userNl->save();
  }

  /**
   * Test language access works on node admin screens.
   */
  public function testNodeForm(): void {
    $this->drupalLogin($this->userEn);
    $this->drupalGet('en/node/add/page');

    $this->assertSession()->optionExists('langcode[0][value]', 'en');
    $this->assertSession()->optionExists('langcode[0][value]', 'und');
    $this->assertSession()->optionExists('langcode[0][value]', 'zxx');
    $this->assertSession()->optionNotExists('langcode[0][value]', 'nl');

    $this->drupalLogin($this->userNl);
    $this->drupalGet('nl/node/add/page');

    $this->assertSession()->optionExists('langcode[0][value]', 'nl');
    $this->assertSession()->optionExists('langcode[0][value]', 'und');
    $this->assertSession()->optionExists('langcode[0][value]', 'zxx');
    $this->assertSession()->optionNotExists('langcode[0][value]', 'en');
  }

  /**
   * Test language access works on taxonomy term admin screens.
   */
  public function testTaxonomyTermForm(): void {
    $this->drupalLogin($this->userEn);
    $this->drupalGet('en/admin/structure/taxonomy/manage/tags/add');

    $this->assertSession()->optionExists('langcode[0][value]', 'en');
    $this->assertSession()->optionExists('langcode[0][value]', 'und');
    $this->assertSession()->optionExists('langcode[0][value]', 'zxx');
    $this->assertSession()->optionNotExists('langcode[0][value]', 'nl');

    $this->drupalLogin($this->userNl);
    $this->drupalGet('nl/admin/structure/taxonomy/manage/tags/add');

    $this->assertSession()->optionExists('langcode[0][value]', 'nl');
    $this->assertSession()->optionExists('langcode[0][value]', 'und');
    $this->assertSession()->optionExists('langcode[0][value]', 'zxx');
    $this->assertSession()->optionNotExists('langcode[0][value]', 'en');
  }

  /**
   * Test language access works on user admin screens.
   */
  public function testUserForm(): void {
    $this->drupalLogin($this->userEn);
    $this->drupalGet('en/user/' . $this->userEn->id() . '/edit');

    $this->assertSession()->optionExists('preferred_langcode', 'en');
    $this->assertSession()->optionNotExists('preferred_langcode', 'nl');

    $this->drupalLogin($this->userNl);
    $this->drupalGet('en/user/' . $this->userNl->id() . '/edit');

    $this->assertSession()->optionExists('preferred_langcode', 'nl');
    $this->assertSession()->optionNotExists('preferred_langcode', 'en');
  }

}
