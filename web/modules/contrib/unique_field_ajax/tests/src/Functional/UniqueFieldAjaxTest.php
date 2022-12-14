<?php

namespace Drupal\Tests\unique_field_ajax\Functional;

/**
 * Test the unique field ajax settings.
 *
 * @package Drupal\Tests\unique_field_ajax
 *
 * @group unique_field_ajax
 */
class UniqueFieldAjaxTest extends UniqueFieldAjaxBase {

  /**
   * Test if not field is not enabled we can edit without issues.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueFieldNotEnabledNoIssues() {
    foreach ($this->fieldTypes as $field_type) {
      $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
      $field_name = $this->fieldStorage->getName();

      // Field unique is not enabled should be able to create anything.
      $this->updateThirdPartyFieldSetting('unique', FALSE);
      $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
      $this->itCanSaveField($edit);
      $this->itCanSaveField($edit);
      $this->itCanSaveField($edit);
      $this->itCanSaveField($edit);
    }
  }

  /**
   * Test saving possible if no enforce enabled.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueFieldNoEnforceEnabled() {
    foreach ($this->fieldTypes as $field_type) {
      $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
      $field_name = $this->fieldStorage->getName();

      // Field unique enabled, no enforce enabled, saving should be possible.
      $this->updateThirdPartyFieldSetting('unique', TRUE);
      $this->updateThirdPartyFieldSetting('no_enforce', TRUE);
      $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
      $this->itCanSaveField($edit);
      $this->itCanSaveField($edit);
      $this->itCanSaveField($edit);
      $this->itCanSaveField($edit);
    }
  }

  /**
   * Test if field enabled uniqueness is required we get errors.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueFieldEnabledRequiredUniqueness() {
    foreach ($this->fieldTypes as $field_type) {
      $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
      $field_name = $this->fieldStorage->getName();

      // Field enabled requires value to be unique.
      // We create a new one and then try to create another which should fail.
      $this->updateThirdPartyFieldSetting('unique', TRUE);
      $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
      $this->itCanSaveField($edit);
      $this->itCannotSaveField($edit);
    }
  }

  /**
   * Test if field unique is enabled you can still save the same node.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueFieldAllowsSavingSameField() {
    foreach ($this->fieldTypes as $field_type) {
      $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
      $field_name = $this->fieldStorage->getName();

      // Field does not get triggered as unique if edited and saved.
      // We create a new one and then update it twice.
      $this->updateThirdPartyFieldSetting('unique', TRUE);
      $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
      $id = $this->itCanSaveField($edit);
      $this->itCanUpdateField($edit, $id);
      $this->itCanUpdateField($edit, $id);
    }
  }

  /**
   * Tests field case insensitivity.
   *
   * @throws \Behat\Mink\Exception\ResponseTextException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function testUniqueFieldCaseInsensitivity() {
    $field_type = $this->fieldTypes['string'];

    $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
    $field_name = $this->fieldStorage->getName();
    $effect = $field_type['effect'];

    $this->updateThirdPartyFieldSetting('unique', TRUE);
    $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $effect);

    // "Tree" should be equal to "tree".
    $edit["{$field_name}[0][{$effect}]"] = "Tree";
    $this->itCanSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "tree";
    $this->itCannotSaveField($edit);
  }

  /**
   * Tests title case insensitivity.
   *
   * @throws \Behat\Mink\Exception\ResponseTextException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function testUniqueTitleCaseInsensitivity() {
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $edit = $this->createBasicUpdateData();

    // "Tree" should be equal to "tree".
    $edit["title[0][value]"] = "Tree";
    $this->itCanSaveField($edit);
    $edit["title[0][value]"] = "tree";
    $this->itCannotSaveField($edit, NULL, NULL, 'title');
  }

  /**
   * Tests field case sensitivity.
   *
   * @throws \Behat\Mink\Exception\ResponseTextException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function testUniqueFieldCaseSensitivity() {
    $field_type = $this->fieldTypes['string'];

    $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
    $field_name = $this->fieldStorage->getName();
    $effect = $field_type['effect'];

    $this->updateThirdPartyFieldSetting('unique', TRUE);
    $this->updateThirdPartyFieldSetting('case_sensitive', TRUE);
    $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $effect);

    // "Tree" should not equal "tree".
    $edit["{$field_name}[0][{$effect}]"] = "Tree";
    $this->itCanSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "tree";
    $this->itCanSaveField($edit);

    // Trying multiple versions of "happy birthday".
    $edit["{$field_name}[0][{$effect}]"] = "Happy Birthday";
    $this->itCanSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "Happy birthday";
    $this->itCanSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "Happy Birthday";
    $this->itCannotSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "Happy BirthDay";
    $this->itCanSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "happy Birthday";
    $this->itCanSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "happy Birthday";
    $this->itCannotSaveField($edit);
    $edit["{$field_name}[0][{$effect}]"] = "happy birthday";
    $this->itCanSaveField($edit);
  }

  /**
   * Tests title case sensitivity.
   *
   * @throws \Behat\Mink\Exception\ResponseTextException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function testUniqueTitleCaseSensitivity() {
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $this->updateThirdPartyEntitySetting('case_sensitive', TRUE);
    $edit = $this->createBasicUpdateData();

    // "Tree" should not equal to "tree".
    $edit["title[0][value]"] = "Tree";
    $this->itCanSaveField($edit);
    $edit["title[0][value]"] = "tree";
    $this->itCanSaveField($edit);

    // Trying multiple versions of "happy birthday".
    $edit["title[0][value]"] = "Happy Birthday";
    $this->itCanSaveField($edit);
    $edit["title[0][value]"] = "Happy birthday";
    $this->itCanSaveField($edit);
    $edit["title[0][value]"] = "Happy Birthday";
    $this->itCannotSaveField($edit, NULL, NULL, 'title');
    $edit["title[0][value]"] = "Happy BirthDay";
    $this->itCanSaveField($edit);
    $edit["title[0][value]"] = "happy Birthday";
    $this->itCanSaveField($edit);
    $edit["title[0][value]"] = "happy Birthday";
    $this->itCannotSaveField($edit, NULL, NULL, 'title');
    $edit["title[0][value]"] = "happy birthday";
    $this->itCanSaveField($edit);
  }

  /**
   * Test if title not set to unique we can save without issues.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueTitleNotEnabledNoIssues() {
    // Setting the entity unique to false we can create many nodes with same.
    $this->updateThirdPartyEntitySetting('unique', FALSE);
    $edit = $this->createBasicUpdateData();
    $this->itCanSaveField($edit);
    $this->itCanSaveField($edit);
    $this->itCanSaveField($edit);
    $this->itCanSaveField($edit);
  }

  /**
   * Test if title enabled uniqueness is required we get errors.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueTitleEnabledRequiredUniqueness() {
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $edit = $this->createBasicUpdateData();
    $this->itCanSaveField($edit);
    $this->itCannotSaveField($edit, NULL, NULL, 'title');
  }

  /**
   * Test if title unique is enabled you can still save the same node.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueTitleAllowsSavingSameField() {
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $edit = $this->createBasicUpdateData();
    $id = $this->itCanSaveField($edit);
    $this->itCanUpdateField($edit, $id);
    $this->itCanUpdateField($edit, $id);
  }

  /**
   * Tests unique field custom message.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueFieldCustomMessage() {
    foreach ($this->fieldTypes as $field_type) {
      $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
      $field_name = $this->fieldStorage->getName();

      // Create a random sentence.
      $msg = $this->createRandomData('sentence');

      // With a custom message this is presented if errors.
      $this->updateThirdPartyFieldSetting('unique', TRUE);
      $this->updateThirdPartyFieldSetting('message', $msg);
      $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
      $this->itCanSaveField($edit);
      $this->itCannotSaveField($edit, $msg);

      // Not adding a custom message falls back to default.
      $this->updateThirdPartyFieldSetting('unique', TRUE);
      $this->updateThirdPartyFieldSetting('message', '');
      $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
      $this->itCanSaveField($edit);
      $this->itCannotSaveField($edit);
    }
  }

  /**
   * Tests unique field custom message with an added label token.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueFieldCustomMessageWithLabelToken() {
    foreach ($this->fieldTypes as $field_type) {
      $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
      $field_name = $this->fieldStorage->getName();

      // Create a random sentence including the label token.
      $msg = $this->createRandomData('sentence');
      $msg .= " Here is my field label: %label ";
      $msg .= $this->createRandomData('sentence');

      // The unique and set a the custom message then create a basic node.
      $this->updateThirdPartyFieldSetting('unique', TRUE);
      $this->updateThirdPartyFieldSetting('message', $msg);
      $edit = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
      $this->itCanSaveField($edit);

      // Create again this time expect the custom message to be displayed.
      $msg = str_replace('%label', $field_name . "_label", $msg);
      $this->itCannotSaveField($edit, $msg);
    }
  }

  /**
   * Tests unique field custom message with an added link token.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueFieldCustomMessageWithLinkToken() {
    $num = 5;
    foreach ($this->fieldTypes as $field_type) {
      $this->createField($field_type['type'], $field_type['widget'], $field_type['settings']);
      $field_name = $this->fieldStorage->getName();

      // Create a random sentence including the label token.
      $msg = $this->createRandomData('sentence');
      $msg .= " Here is my field link: %link";

      // Enable unique and set a custom message then create a basic node.
      $this->updateThirdPartyFieldSetting('unique', TRUE);
      $this->updateThirdPartyFieldSetting('message', $msg);

      // Create a random number of nodes saving the data for later.
      $edits = [];
      for ($i = 0; $i < $num; $i++) {
        $edits[$i] = $this->createUpdateFieldData($field_name, $field_type['value'], $field_type['effect']);
        $this->itCanSaveField($edits[$i]);
      }

      // Pick a random edit and see if it tries to link to it.
      $edit = $edits[array_rand($edits)];
      $msg = str_replace('%link', $edit['title[0][value]'], $msg);
      $this->itCannotSaveField($edit, $msg);
    }
  }

  /**
   * Tests unique title custom message.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueTitleCustomMessage() {
    // Create a random sentence.
    $msg = $this->createRandomData('sentence');

    // With a custom message this is presented if errors.
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $this->updateThirdPartyEntitySetting('message', $msg);
    $edit = $this->createBasicUpdateData();
    $this->itCanSaveField($edit);
    $this->itCannotSaveField($edit, $msg, NULL, 'title');

    // With a custom message this is presented if errors.
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $this->updateThirdPartyEntitySetting('message', '');
    $edit = $this->createBasicUpdateData();
    $this->itCanSaveField($edit);
    $this->itCannotSaveField($edit, NULL, NULL, 'title');
  }

  /**
   * Tests unique title custom message with an added label token.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueTitleCustomMessageWithLabelToken() {
    // Create a random sentence including the label token.
    $msg = $this->createRandomData('sentence');
    $msg .= " Here is my title label: %label ";
    $msg .= $this->createRandomData('sentence');

    // Enable the unique and set a the custom message then create a basic node.
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $this->updateThirdPartyEntitySetting('message', $msg);
    $edit = $this->createBasicUpdateData();
    $this->itCanSaveField($edit);

    // Try to create again this time expect the custom message to be displayed.
    $msg = str_replace('%label', "title", $msg);
    $this->itCannotSaveField($edit, $msg, NULL, 'title');
  }

  /**
   * Tests unique title custom message with an added link token.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testUniqueTitleCustomMessageWithLinkToken() {
    $num = 5;
    // Create a random sentence including the label token.
    $msg = $this->createRandomData('sentence');
    $msg .= " Here is my title link: %link";

    // Enable the unique and set a the custom message then create a basic node.
    $this->updateThirdPartyEntitySetting('unique', TRUE);
    $this->updateThirdPartyEntitySetting('message', $msg);

    // Create a random number of nodes saving the data for later.
    $edits = [];
    for ($i = 0; $i < $num; $i++) {
      $edits[$i] = $this->createBasicUpdateData();
      $this->itCanSaveField($edits[$i]);
    }

    // Pick a random edit and see if it tries to link to it.
    $edit = $edits[array_rand($edits)];
    $msg = str_replace('%link', $edit['title[0][value]'], $msg);
    $this->itCannotSaveField($edit, $msg, NULL, 'title');
  }

}
