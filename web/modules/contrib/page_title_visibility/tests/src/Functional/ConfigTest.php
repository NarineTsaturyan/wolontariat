<?php

namespace Drupal\Tests\page_title_visibility\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests routes info pages and links.
 *
 * @group page_title_visibility
 */
class ConfigTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'page_title_visibility',
  ];

  /**
   * Specify the theme to be used in testing.
   *
   * @var string
   */
  protected $defaultTheme = 'stable';

  /**
   * Tests entity saves all components of the entity on the DB.
   */
  public function testSaveConfig() {
    $config = \Drupal::config('page_title_visibility.content_type.article');
    // By default, the page title is not set.
    $this->assertEquals($config->get('display_page_title'), NULL);
    $config = \Drupal::service('config.factory')->getEditable('page_title_visibility.content_type.article');
    $config->set('display_page_title', 0)->save();
    // Verify the default choice can be overridden to display "off".
    $this->assertEquals($config->get('display_page_title'), 0);
    $config = \Drupal::service('config.factory')->getEditable('page_title_visibility.content_type.article');
    $config->set('display_page_title', 1)->save();
    // Verify the default choice can be overridden to display "on".
    $this->assertEquals($config->get('display_page_title'), 1);
  }

}
