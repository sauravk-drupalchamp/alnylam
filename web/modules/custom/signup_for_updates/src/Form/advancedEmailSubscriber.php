<?php

namespace Drupal\signup_for_updates\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implements a codimth Config Form API.
 */
class advancedEmailSubscriber extends ConfigFormBase
{


  /**
   * @return string
   */
  public function getFormId()
  {
    return 'signup_for_updates_admin_settings';
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames()
  {
    return [
      'signup_for_updates.settings',
    ];
  }


  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('signup_for_updates.settings');

    $form['client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CLIENT_ID:'),
      '#default_value' => $config->get('client_id'),
    ];

    $form['client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CLIENT_SECRET:'),
      '#default_value' => $config->get('client_secret'),
    ];
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('USERNAME'),
      '#default_value' => $config->get('username'),
    ];
    $form['password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PASSWORD:'),
      '#default_value' => $config->get('password'),
    ];

    $form['token_url'] = [
      '#type' => 'url',
      '#title' => $this->t('TOKENURL:'),
      '#default_value' => $config->get('token_url'),
      // '#options' => ['external' => TRUE]
    ];

    $form['base_url'] = [
      '#type' => 'url',
      '#title' => $this->t('BASEURL:'),
      '#default_value' => $config->get('base_url'),
    ];
    $form['sign_up'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SIGNUP:'),
      '#default_value' => $config->get('sign_up'),
    ];

    $form['update_subscriber'] = [
      '#type' => 'textfield',
      '#title' => $this->t('UPDATESUBSCRIBER:'),
      '#default_value' => $config->get('update_subscriber'),
    ];

    $form['subscriber_detail'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SUBSCRIBERDETAIL:'),
      '#default_value' => $config->get('subscriber_detail'),
    ];


    $form['check_mail'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHECKEMAIL:'),
      '#default_value' => $config->get('check_mail'),
    ];
    $form['notify_email_tomc'] = [
      '#type' => 'textfield',
      '#title' => $this->t('NOTIFYEMAILTOMC:'),
      '#default_value' => $config->get('notify_email_tomc'),
    ];


    // $form['tokenurl'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('TOKENURL:'),
    //   '#default_value' => $config->get('tokenurl'),
    // ];
    // $form['base_url'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('BASEURL:'),
    //   '#default_value' => $config->get('base_url'),
    // ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $config = $this->config('signup_for_updates.settings');
    $config->set('client_id', $form_state->getValue('client_id'))->save();
    $config->set('client_secret', $form_state->getValue('client_secret'))->save();
    $config->set('username', $form_state->getValue('username'))->save();
    $config->set('password', $form_state->getValue('password'))->save();
    $config->set('token_url', $form_state->getValue('token_url'))->save();
    $config->set('base_url', $form_state->getValue('base_url'))->save();
    $config->set('sign_up', $form_state->getValue('sign_up'))->save();
    $config->set('update_subscriber', $form_state->getValue('update_subscriber'))->save();
    $config->set('subscriber_detail', $form_state->getValue('subscriber_detail'))->save();
    $config->set('check_mail', $form_state->getValue('check_mail'))->save();
    $config->set('notify_email_tomc', $form_state->getValue('notify_email_tomc'))->save();
  }


}