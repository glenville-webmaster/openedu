<?php

namespace Drupal\openedu_subtheme\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'subtheme_settings_widget_type' widget.
 *
 * @FieldWidget(
 *   id = "subtheme_settings_widget_type",
 *   label = @Translation("Subtheme Settings Widget"),
 *   field_types = {
 *     "subtheme_settings_field_type"
 *   }
 * )
 */
class SubthemeSettingsWidgetType extends WidgetBase {

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
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : '{}',
      '#attached' => [
        'library' => ['openedu_subtheme/sub_color.init'],
      ],
      '#attributes' => ['id' => 'js-sub-color-json'],
      '#maxlength' => $this->getFieldSetting('max_length'),
    ];
    $element_color = [
      '#type' => 'details',
      '#prefix' => '<div id="system-theme-settings">',
      '#title' => t('Color scheme'),
      '#open' => TRUE,
      '#weight' => -1,
      '#attributes' => ['id' => 'color_scheme_form'],
      '#theme' => 'color_scheme_form',
      '#suffix' => '</div>',
    ];
    if (isset($form['parent_machine_name']) && !empty($form['parent_machine_name']['widget']['#default_value'])) {
      $theme = $form['parent_machine_name']['widget']['#default_value'][0];
    }
    else {
      $theme = "oedu_sub";
    }
    $element_color += color_scheme_form($form, $form_state, $theme);
    $element_color['scheme']['#id'] = 'edit-scheme';
    if (isset($items[$delta]->value)) {
      $json = json_decode($items[$delta]->value, TRUE);
    }

    $current_scheme = \Drupal::configFactory()->getEditable("color.theme.$theme")->get('palette');
    $default_palette = color_get_palette($theme, TRUE);
    $palette = $current_scheme ?: $default_palette;
    foreach ($palette as $name => $value) {
      $element_color['palette'][$name]['#id'] = "edit-palette-$name";
      if (isset($json[$name]) && $json[$name] != $value) {
        $element_color['palette'][$name]['#default_value'] = $json[$name];
      }
    }
    $element['color'] = $element_color;

    return $element;
  }

}
