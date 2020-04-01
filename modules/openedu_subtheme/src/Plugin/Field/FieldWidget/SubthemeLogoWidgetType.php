<?php

namespace Drupal\openedu_subtheme\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'subtheme_logo_widget_type' widget.
 *
 * @FieldWidget(
 *   id = "subtheme_logo_widget_type",
 *   label = @Translation("Subtheme logo widget type"),
 *   field_types = {
 *     "subtheme_logo_field_type"
 *   }
 * )
 */
class SubthemeLogoWidgetType extends WidgetBase {

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
      '#type' => 'hidden',
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#maxlength' => $this->getFieldSetting('max_length'),
      '#attached' => [
        'library' => ['openedu_subtheme/sub_theme_entity'],
      ],
      '#attributes' => [
        'id' => 'subtheme-logo-fid',
      ],
    ];

    $element['logo'] = [
      '#type' => 'details',
      '#title' => t('Upload Logo image'),
      '#open' => TRUE,
    ];

    $element['logo']['logo_upload'] = [
      '#type' => 'managed_file',
      '#title' => t('Logo Image'),
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg gif svg'],
      ],
      '#upload_location' => 'public://',
      '#default_value' => isset($items[$delta]->value) ? [$items[$delta]->value] : NULL,
    ];

    return $element;
  }

}
