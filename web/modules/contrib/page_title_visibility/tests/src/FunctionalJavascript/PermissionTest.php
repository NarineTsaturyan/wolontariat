<?php

namespace Drupal\Tests\page_title_visibility\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use Drupal\Core\Field\Entity\BaseFieldOverride;
use Drupal\node\Entity\NodeType;

/**
 * Tests that the module defined permission does limit user actions.
 *
 * @group page_title_visibility
 */
class PermissionTest extends WebDriverTestBase {

  /**
   * Use the 'minimal' installation profile.
   *
   * @var string
   */
  protected $profile = 'minimal';

  /**
   * Specify the theme to be used in testing.
   *
   * @var string
   */
  protected $defaultTheme = 'bartik';

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'node',
    'page_title_visibility',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $nodeType = NodeType::create([
      'type' => 'test',
      'name' => 'Test',
    ]);
    $nodeType->save();
    $entity = BaseFieldOverride::create([
      'field_name' => 'status',
      'entity_type' => 'node',
      'bundle' => 'test',
    ]);
    $entity->setDefaultValue(TRUE)->save();

    $account = $this->drupalCreateUser([
      'create test content',
      'edit own test content',
      'administer nodes',
      'administer page display visibility config',
      'administer content types',
    ]);
    $this->drupalLogin($account);
  }

  /**
   * Test the visibility of the title block on a per-node basis.
   */
  public function testNodeLevelPermission() {
    $session = $this->getSession();
    $web_assert = $this->assertSession();
    $page = $session->getPage();

    // Go to node creation page.
    $this->drupalGet('node/add/test');
    // Find the v-tab provided by the module and click it.
    $page->findLink('Page display options')->click();
    // Confirm the "display title" checbox is checked by default.
    $page->hasCheckedField('#edit-display-page-title-value');
    // Get random title and save the node.
    $title = $this->randomString();
    $edit = [
      'title[0][value]' => $title,
    ];
    $this->submitForm($edit, 'Save');
    // Confirm a new Test type node was created.
    $web_assert->pageTextContains('Test ' . $title . ' has been created.');
    // Verify the page title selector has no 'visually-hidden's attribute.
    $web_assert->elementAttributeNotContains('css', '.block-page-title-block', 'class', 'visually-hidden');
    // Grab the node id by its title and load the node edit page.
    $node = $this->drupalGetNodeByTitle($title);
    $this->drupalGet('node/' . $node->id() . '/edit');
    // Go to the Page Display Options v-tab section.
    $page->findLink('Page display options')->click();
    // Uncheck the "Page Visibility" checkbox and save the node.
    $page->uncheckField('edit-display-page-title-value');
    $this->submitForm([], 'Save');
    // Confirm the same node was updated successfully.
    $web_assert->pageTextContains('Test ' . $title . ' has been updated.');
    // Confirm that you can find the visually-hidden class, meaning that the
    // page_title block should be hidden.
    $web_assert->elementAttributeContains('css', '.block-page-title-block', 'class', 'visually-hidden');
    // Logout.
    $this->drupalLogout();
    // Create a new user without the permission to edit page title visibility.
    $account = $this->drupalCreateUser([
      'create test content',
      'edit any test content',
      'administer nodes',
    ]);
    // Login with the new user.
    $this->drupalLogin($account);
    // Edit the same existing node.
    $this->drupalGet('node/' . $node->id() . '/edit');
    // Go to the Page Display Options v-tab section.
    $page->findLink('Page display options')->click();
    // Confirm the checbox is disabled with a descriptive message.
    $web_assert->elementAttributeContains('css', '#edit-display-page-title-value', 'disabled', 'disabled');
    $web_assert->elementTextContains('css', '#edit-display-page-title-value--description', 'Your account does not have permission to set the page title visibility.');
    // Logout to end test.
    $this->drupalLogout();
  }

  /**
   * Test the visibility of the title block on a per-content type basis.
   */
  public function testContentTypeLevelPermission() {
    $session = $this->getSession();
    $web_assert = $this->assertSession();
    $page = $session->getPage();

    // Go to the Test content type edit page.
    $this->drupalGet('admin/structure/types/manage/test');
    // Find the v-tab provided by the module and click it.
    $page->findLink('Page display defaults')->click();
    // Confirm the "display title" checbox is checked by default.
    $page->hasCheckedField('#edit-display-page-title');
    // Uncheck the "Page Visibility" checkbox and save the CT settings.
    $page->uncheckField('edit-display-page-title');
    $this->submitForm([], 'Save content type');
    // Go to node creation page.
    $this->drupalGet('node/add/test');
    // Find the v-tab provided by the module and click it.
    $page->findLink('Page display options')->click();
    // Confirm the "display title" checbox is unchecked by default.
    $page->hasUncheckedField('#edit-display-page-title-value');
    // Logout.
    $this->drupalLogout();
    // Add a new user without the permission to edit CT page title visibility.
    $account = $this->drupalCreateUser([
      'administer content types',
    ]);
    // Login with the new user.
    $this->drupalLogin($account);
    // Go to the Test content type edit page.
    $this->drupalGet('admin/structure/types/manage/test');
    // Find the v-tab provided by the module and click it.
    $page->findLink('Page display defaults')->click();
    // Confirm the checbox is disabled with a descriptive message.
    $web_assert->elementAttributeContains('css', '#edit-display-page-title', 'disabled', 'disabled');
    $web_assert->elementTextContains('css', '#edit-display-page-title--description', 'Your account does not have permission to set the page title visibility.');
    // Logout to end test.
    $this->drupalLogout();
  }

}
