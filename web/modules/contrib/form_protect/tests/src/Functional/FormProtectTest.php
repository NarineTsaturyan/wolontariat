<?php

namespace Drupal\Tests\form_protect\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

/**
 * Tests Form Protect functionality.
 *
 * @group form_protect
 */
class FormProtectTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'form_protect_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Tests if the forms action attribute has changed and
   * Drupal.settings.formProtect contains the correct values.
   */
  public function testFormProtect() {
    // Add the 2 forms to the form protected list.
    $this->config('form_protect.settings')
      ->set('form_ids', ['form_protect_test_form1', 'form_protect_test_form2'])
      ->save();
    $this->drupalGet('form_protect_test');

    $form_protect_settings  = $this->getDrupalSettings()['formProtect'];
    ksort($form_protect_settings);
    $action = Url::fromRoute('form_protect_test.page')->toString();
    $this->assertSame([
      'form-protect-test-form1' => $action,
      'form-protect-test-form2' => $action,
    ], $form_protect_settings);

    $fake_action = Url::fromRoute('form_protect.submit')->toString();
    $xpath = $this->xpath("//form[@id='form-protect-test-form1']");
    $action = $xpath[0]->getAttribute('action');
    $this->assertSame($fake_action, $action);
    $xpath = $this->xpath("//form[@id='form-protect-test-form2']");
    $action = $xpath[0]->getAttribute('action');
    $this->assertSame($fake_action, $action);

    $this->drupalPostForm(NULL, [], 'Bar1');
    $this->assertSession()->pageTextContains('JavaScript is not enabled in your browser. This form requires JavaScript to be enabled.');

    // The fake submit page should be accessible only by POST method.
    $this->drupalGet('submit/form');
    $this->assertSession()->statusCodeEquals(403);

    // This is not a standard Drupal form submission, it should fail with 403.
    $url = Url::fromUri('internal:/submit/form')->setAbsolute()->toString();
    $response = $this->getHttpClient()->post($url, [
      'form_params' => ['foo' => 'bar'],
      'http_errors' => FALSE,
    ]);
    $this->assertSame(403, $response->getStatusCode());
  }

}
