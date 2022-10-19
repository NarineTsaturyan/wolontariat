<?php

namespace Drupal\consent_manager\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for the Consent Manager settings.
 */
class ConsentManagerSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'consent_manager.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'consent_manager_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('consent_manager.settings');
    $form['blocking_mode'] = [
      '#type' => 'select',
      '#title' => $this->t('Blocking mode'),
      '#options' => [
        'automatic' => $this->t('Automatic blocking'),
        'semi_automatic' => $this->t('Semi-Automatic blocking'),
      ],
      '#default_value' => $config->get('blocking_mode') ?? 'semi_automatic',
      '#required' => TRUE,
    ];
    $form['cmp_id'] = [
      '#type' => 'number',
      '#title' => $this->t('Id'),
      '#description' => $this->t('If you don\'t yet have an ID, please get in on <a href=":url" target="_blank">www.consentmanager.net</a>', [':url' => 'https://www.consentmanager.net/client/codes.php']),
      '#default_value' => $config->get('cmp_id'),
      '#min' => 1,
      '#step' => 1,
      '#required' => TRUE,
    ];
    $form['custom_code'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Custom HTML code'),
      '#description' => $this->t('Additional HTML code: appears before the consent manager integration markup.'),
      '#default_value' => $config->get('custom_code'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('consent_manager.settings')
      ->set('blocking_mode', $form_state->getValue('blocking_mode'))
      ->set('cmp_id', $form_state->getValue('cmp_id'))
      ->set('custom_code', $form_state->getValue('custom_code'))
      ->save();
  }

}
