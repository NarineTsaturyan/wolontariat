<?php

namespace Drupal\consent_manager\Form;

use Drupal\consent_manager\CodeManager;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for the Consent Manager settings.
 */
class ConsentManagerSettingsForm extends ConfigFormBase {

  /**
   * The module extension list.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $moduleExtensionList;

  /**
   * Constructs a \Drupal\consent_manager\Form\ConsentManagerSettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Extension\ModuleExtensionList $module_extension_list
   *   The module extension list.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ModuleExtensionList $module_extension_list) {
    parent::__construct($config_factory);
    $this->moduleExtensionList = $module_extension_list;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('extension.list.module'),
    );
  }

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
    $path = '/' . $this->moduleExtensionList->getPath('consent_manager');

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

    $form['cdid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Code-ID'),
      '#description' => $this->t('If you don\'t yet have an Code-ID, please get in on <a href=":url" target="_blank">www.consentmanager.net</a>', [':url' => 'https://www.consentmanager.net/client/codes.php']),
      '#default_value' => $config->get('cdid'),
      '#required' => TRUE,
    ];

    $form['cdid_image'] = [
      '#type' => 'html_tag',
      '#tag' => 'img',
      '#attributes' => [
        'src' => $path . '/images/cmpcodeid.png',
        'width' => '500',
        'height' => 'auto',
      ],
    ];

    $form['host'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Host'),
      '#description' => $this->t('Leave blank to use the default value: %default_value. You need to specify the host name value only (without the protocol https://).', ['%default_value' => CodeManager::DEFAULT_HOST]),
      '#default_value' => $config->get('host'),
    ];

    $form['host_image'] = [
      '#type' => 'html_tag',
      '#tag' => 'img',
      '#attributes' => [
        'src' => $path . '/images/cmphost.png',
        'width' => '500',
        'height' => 'auto',
      ],
    ];

    $form['cdn'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CDN'),
      '#description' =>$this->t('Leave blank to use the default value: %default_value. You need to specify the host name value only (without the protocol https://).', ['%default_value' => CodeManager::DEFAULT_CDN]),
      '#default_value' => $config->get('cdn'),
    ];

    $form['cdn_image'] = [
      '#type' => 'html_tag',
      '#tag' => 'img',
      '#attributes' => [
        'src' => $path . '/images/cmpcdn.png',
        'width' => '500',
        'height' => 'auto',
      ],
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
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $host = $form_state->getValue('host');
    if ($host && !filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
      $form_state->setErrorByName('host', $this->t('Wrong host value.'));
    }

    $cdn = $form_state->getValue('cdn');
    if ($cdn && !filter_var($cdn, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
      $form_state->setErrorByName('cdn', $this->t('Wrong CDN value.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('consent_manager.settings')
      ->set('blocking_mode', $form_state->getValue('blocking_mode'))
      ->set('cdid', trim($form_state->getValue('cdid')))
      ->set('host', trim($form_state->getValue('host')))
      ->set('cdn', trim($form_state->getValue('cdn')))
      ->set('custom_code', trim($form_state->getValue('custom_code')))
      ->save();
    
    Cache::invalidateTags(['consent_manager']);
  }

}
