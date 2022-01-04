<?php

namespace Drupal\Tests\language_access\Functional;

use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\StreamWrapper\PublicStream;

/**
 * Class LanguageAccessTest.
 *
 * @group language_access
 *
 * @package Drupal\Tests\language_access\Functional
 */
class LanguageAccessTest extends LanguageAccessTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'block',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $this->drupalPlaceBlock('language_block:' . LanguageInterface::TYPE_INTERFACE);
  }

  /**
   * Test that the user does not have access to a disabled language.
   */
  public function testLanguageAccess(): void {
    $this->drupalLogin($this->userEn);
    $this->drupalGet('en/node/1');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('nl/node/1');
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Test that disabling the default language works.
   */
  public function testDisableDefaultLanguage(): void {
    $this->drupalLogin($this->userNl);
    $this->drupalGet('en/node/1');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('nl/node/1');
    $this->assertSession()->statusCodeEquals(200);
  }

  /**
   * Test that access is still allowed to excluded pages like the user pages.
   */
  public function testExcludedPages(): void {
    $this->drupalLogin($this->userNl);
    $this->drupalGet('en/user/' . $this->userNl->id());
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('nl/user/' . $this->userNl->id());
    $this->assertSession()->statusCodeEquals(200);

    // This is an unexisting file, so it will result in a 404 when this URL is
    // not blocked by the language_access module.
    $this->drupalGet(PublicStream::basePath() . '/styles/large/test.png');
    $this->assertSession()->statusCodeEquals(404);
  }

  /**
   * Test that the language switching block only shows the allowed languages.
   */
  public function testLanguageSwitchingBlock(): void {
    $this->drupalLogin($this->userEn);
    $this->drupalGet('<front>');

    $this->assertSession()->linkExists('English');
    $this->assertSession()->linkNotExists('Dutch');

    $this->drupalLogin($this->userNl);
    $this->drupalGet('<front>');

    $this->assertSession()->linkNotExists('English');
    $this->assertSession()->linkExists('Dutch');
  }

}
