<?php

namespace Drupal\webform_vas_element\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformElementBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Provides a 'webform_vas_element' element.
 *
 * @WebformElement(
 *   id = "webform_vas_element",
 *   label = @Translation("Webform vas element"),
 *   description = @Translation("Provides a webform element example."),
 *   category = @Translation("VAS elements"),
 * )
 *
 * @see \Drupal\webform_vas_element\Element\WebformVasElement
 * @see \Drupal\webform\Plugin\WebformElementBase
 * @see \Drupal\webform\Plugin\WebformElementInterface
 * @see \Drupal\webform\Annotation\WebformElement
 */
class WebformVasElement extends WebformElementBase {

  /**
   * {@inheritdoc}
   */
  protected function defineDefaultProperties() {
    // Here you define your webform element's default properties,
    // which can be inherited.
    //
    // @see \Drupal\webform\Plugin\WebformElementBase::defaultProperties
    // @see \Drupal\webform\Plugin\WebformElementBase::defaultBaseProperties
    $properties = [
        'minimum' => '0',
        'maximum' => '100',
        'step' => '1',
        'low' => '',
        'high' => '',
        'display_vertical' => '',
      ] + parent::defineDefaultProperties();
    unset($properties['field_prefix']);
    unset($properties['field_suffix']);
    return $properties;
  }

  /****************************************************************************/

  /**
   * {@inheritdoc}
   */
  public function prepare(array &$element, WebformSubmissionInterface $webform_submission = NULL) {
    parent::prepare($element, $webform_submission);

    // Here you can customize the webform element's properties.
    // You can also customize the form/render element's properties via the
    // FormElement.
    //
    // @see \Drupal\webform_example_element\Element\WebformExampleElement::processWebformElementExample
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    // Here you can define and alter a webform element's properties UI.
    // Form element property visibility and default values are defined via
    // ::defaultProperties.
    //
    // @see \Drupal\webform\Plugin\WebformElementBase::form
    // @see \Drupal\webform\Plugin\WebformElement\TextBase::form

    $form['time'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Anchor Text'),
    ];
    $form['time']['low'] = [
      '#type' => 'webform_html_editor',
      '#title' => $this->t('Low'),
      '#description' => $this->t('Label for the minimum value in the scale.'),
      '#weight' => -49,
    ];
    $form['time']['high'] = [
      '#type' => 'webform_html_editor',
      '#title' => $this->t('High'),
      '#description' => $this->t('Label for the max value in the scale.'),
      '#weight' => -48,
    ];
    $form['scale'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Scale Settings'),
    ];
    $form['scale']['minimum'] = [
      '#type' => 'number',
      '#title' => $this->t('Minimum'),
      '#description' => $this->t('Input for the Scale Minimum Range'),
      '#min' => 0,
      '#max' => 1000,
      '#default_value' => 0,
      '#weight' => -53,
    ];
    $form['scale']['maximum'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum'),
      '#description' => $this->t('Input for the Scale Maximum Range'),
      '#min' => 10,
      '#max' => 10000,
      '#default_value' => 100,
      '#weight' => -52,
    ];
    $form['scale']['step'] = [
      '#type' => 'number',
      '#title' => $this->t('Steps'),
      '#description' => $this->t('Input for the scale step'),
      '#min' => 1,
      '#max' => 100,
      '#default_value' => 1,
      '#weight' => -51,
    ];
    $form['form']['display_vertical'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display Vertical'),
      '#description' => $this->t('Check this box to set slider position to vertical view.'),
      '#return_value' => TRUE,
      '#weight' => 49,
    ];
    return $form;
  }

}
