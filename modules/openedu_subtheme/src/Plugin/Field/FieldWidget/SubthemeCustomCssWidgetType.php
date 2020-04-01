<?php

namespace Drupal\openedu_subtheme\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'subtheme_custom_css_widget_type' widget.
 *
 * @FieldWidget(
 *   id = "subtheme_custom_css_widget_type",
 *   label = @Translation("Subtheme custom css widget type"),
 *   field_types = {
 *     "subtheme_custom_css_field_type"
 *   }
 * )
 */
class SubthemeCustomCssWidgetType extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'size' => 60,
      'placeholder' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['size'] = [
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $elements['placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = t('Textfield size: @size', ['@size' => $this->getSetting('size')]);
    if (!empty($this->getSetting('placeholder'))) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $this->getSetting('placeholder')]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'textarea',
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : ".css-example {\n\ttext-align: left;\n}",
      '#maxlength' => $this->getFieldSetting('max_length'),
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#id' => "custom-css-textarea",
      '#attributes' => [
        'class' => [
          'custom-css-textarea',
        ],
      ],
    ];
    // Get node types.
    $types = \Drupal::entityTypeManager()->getStorage('node_type')->loadMultiple();
    $css_node_selectors = array_map(function ($type) {
      return str_replace('_', '-', $type);
    }, array_keys($types));

    $element['description'] = [
      '#prefix' => '<div class="description">',
      '#markup' => t('In order to change CSS on each particular page you 
      should use the following selectors:<br/>
      - .page-node-type-{node type};<br/>
      - .page-node-{node ID};<br/>
      - .path-frontpage.<br/><br/>
      The existing node types are: @select.', ['@select' => implode($css_node_selectors, ', ')]),
      '#suffix' => '</div>',
    ];
    $form['#attached'] = [
      'library' => ['openedu_subtheme/monaco.init'],
    ];

    return $element;
  }

}
