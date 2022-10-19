<?php

namespace Drupal\email_blocker\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class which provides the settings form for the module.
 */
class EmailBlockerSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'email_blocker.emailblockersettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'email_blocker_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('email_blocker.emailblockersettings');
    $form['block_emails'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Block Emails'),
      '#description' => $this->t('Enable the setting to block all outgoing emails on the site'),
      '#default_value' => $config->get('block_emails'),
    ];

    $form['display_email'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display Emails'),
      '#description' => $this->t('Display emails'),
      '#default_value' => $config->get('block_email_display_email'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('email_blocker.emailblockersettings')
      ->set('block_emails', $form_state->getValue('block_emails'))
      ->set('block_email_display_email', $form_state->getValue('display_email'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
