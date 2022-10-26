<?php

namespace Drupal\Tests\consent_manager\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group consent_manager
 */
class LoadTest extends BrowserTestBase {

  /**
   * Test CMP ID value.
   */
  const CDID = 'aaaaaaaaaaaa';

  /**
   * Test HOST value.
   */
  const HOST = 'cdn.consentmanager.net';

  /**
   * Test CDN value.
   */
  const CDN = 'delivery.consentmanager.net';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['consent_manager'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stable';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->config('system.site')
      ->set('name', 'ConsentManager')
      ->save(TRUE);
  }

  /**
   * Automatic code test.
   *
   * Tests that the home page loads with a 200 response and with automatic code.
   */
  public function testAutomaticCode() {
    $this->config('consent_manager.settings')
      ->set('cdid', self::CDID)
      ->set('host', self::HOST)
      ->set('cdn', self::CDN)
      ->set('blocking_mode', 'automatic')
      ->set('custom_code', '<meta name="ConsentManager" content="custom_code" />')
      ->save();
    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->responseContains('https://' . self::CDN . '/delivery/autoblocking/' . self::CDID . '.js');
    $this->assertSession()->responseContains('data-cmp-host="' . self::HOST . '"');
    $this->assertSession()->responseContains('data-cmp-cdn="' . self::CDN . '"');
    $xpath = $this->xpath('//head/meta[@name="ConsentManager"]');
    self::assertNotEmpty($xpath, 'Consent Manager custom code markup not found.');
  }

  /**
   * Semi-automatic code test.
   *
   * Tests that the home page loads with a 200 response and with
   * semi-automatic code.
   */
  public function testSemiAutomaticCode() {
    $this->config('consent_manager.settings')
      ->set('cdid', self::CDID)
      ->set('host', self::HOST)
      ->set('cdn', self::CDN)
      ->set('blocking_mode', 'semi_automatic')
      ->set('custom_code', '<meta name="ConsentManager" content="custom_code" />')
      ->save();
    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->responseContains('window.cdid=' . self::CDID);
    $this->assertSession()->responseContains('window.cmp_host=' . self::HOST);
    $this->assertSession()->responseContains('window.cmp_cdn=' . self::CDN);
    $xpath = $this->xpath('//head/meta[@name="ConsentManager"]');
    self::assertNotEmpty($xpath, 'Consent Manager custom code markup not found.');
  }

}
