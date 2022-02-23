<?php

namespace Drupal\user_password_limit\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class UserPasswordLimitSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_password_limit_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['user_password_limit.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['enable_limit'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable limit user password reset'),
      '#description' => $this->t("Maximum password reset count will work only when this is enabled"),
      '#default_value' => \Drupal::config('user_password_limit.settings')->get('limit_enable'),
    ];

    $form['max_password_reset_count'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Maximum number of times user allowed to reset their own password per day'),
      '#default_value' => \Drupal::config('user_password_limit.settings')->get('max_limit'),
      '#maxlength' => 3,
      '#description' => $this->t('The maximum number of times user allowed to reset their own password per day'),
      '#attributes' => array(
        ' type' => 'number', 
      ),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $maxcount = $form_state->getValue(['max_password_reset_count']);
    if (!is_numeric($maxcount)) {
      $form_state->setErrorByName('max_password_reset_count', $this->t('You must enter a number for the maximum number of times user allowed to reset their own password per day'));
    }
    elseif ($maxcount <= 0) {
      $form_state->setErrorByName('max_password_reset_count', $this->t('Maximum number of times user allowed to reset their own password per day must be positive'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config('user_password_limit.settings');

    $config->set('limit_enable', $form_state->getValue($form['enable_limit']['#parents']));
    $config->set('max_limit', $form_state->getValue($form['max_password_reset_count']['#parents']));

    $config->save();

    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }

    parent::submitForm($form, $form_state);
  }

}
