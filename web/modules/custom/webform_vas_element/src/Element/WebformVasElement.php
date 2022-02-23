<?php

namespace Drupal\webform_vas_element\Element;

use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'webform_vas_element'.
 *
 * Webform elements are just wrappers around form elements, therefore every
 * webform element must have correspond FormElement.
 *
 * Below is the definition for a custom 'webform_vas_element' which just
 * renders a simple text field.
 *
 * @FormElement("webform_vas_element")
 *
 * @see \Drupal\Core\Render\Element\FormElement
 * @see https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Render%21Element%21FormElement.php/class/FormElement
 * @see \Drupal\Core\Render\Element\RenderElement
 * @see https://api.drupal.org/api/drupal/namespace/Drupal%21Core%21Render%21Element
 * @see \Drupal\webform_vas_element\Element\WebformVasElement
 */
class WebformVasElement extends FormElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);

    return [
      '#input' => TRUE,
      '#size' => 60,
      '#process' => [
        [$class, 'processWebformVasElement'],
        [$class, 'processAjaxForm'],
      ],
      '#element_validate' => [
        [$class, 'validateWebformVasElement'],
      ],
      '#pre_render' => [
        [$class, 'preRenderWebformVasElement'],
      ],
      '#theme' => 'input__webform_vas_element',
      '#theme_wrappers' => ['form_element'],
    ];
  }

  /**
   * Processes a 'webform_vas_element' element.
   */
  public static function processWebformVasElement(&$element, FormStateInterface $form_state, &$complete_form) {
    // Here you can add and manipulate your element's properties and callbacks.

    if (isset($element['#display_vertical'])) {
      $element['#attached']['drupalSettings']['vas_slider']['elements'][$element['#id']]['desktop_vertical'] = 'vertical';
    }
    if (isset($element['#minimum'])) {
      $element['#attached']['drupalSettings']['vas_slider']['elements'][$element['#id']]['minimum'] = $element['#minimum'];
    }
    if (isset($element['#maximum'])) {
      $element['#attached']['drupalSettings']['vas_slider']['elements'][$element['#id']]['maximum'] = $element['#maximum'];
    }
    if (isset($element['#step'])) {
      $element['#attached']['drupalSettings']['vas_slider']['elements'][$element['#id']]['step'] = $element['#step'];
    }

    $element['#attached']['library'][] = 'webform_vas_element/element.vaslider';
    return $element;
  }

  /**
   * Webform element validation handler for #type 'webform_vas_element'.
   */
  public static function validateWebformVasElement(&$element, FormStateInterface $form_state, &$complete_form) {
    // Here you can add custom validation logic.
  }

  /**
   * Prepares a #type 'email_multiple' render element for theme_element().
   *
   * @param array $element
   *   An associative array containing the properties of the element.
   *   Properties used: #title, #value, #description, #size, #maxlength,
   *   #placeholder, #required, #attributes.
   *
   * @return array
   *   The $element with prepared variables ready for theme_element().
   */
  public static function preRenderWebformVasElement(array $element) {
    $element['#attributes']['type'] = 'number';
    Element::setAttributes($element, ['id', 'name', 'value', 'size', 'maxlength', 'placeholder']);
    static::setAttributes($element, ['form-text', 'webform-vas-element']);
    return $element;
  }

}
