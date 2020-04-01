<?php

namespace Drupal\openedu_subtheme\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Subtheme Entity edit forms.
 *
 * @ingroup openedu_subtheme
 */
class SubthemeEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\openedu_subtheme\Entity\SubthemeEntity */
    $form = parent::buildForm($form, $form_state);
    $form['machine_name']['widget'][0]['value']['#type'] = 'machine_name';
    $form['machine_name']['widget'][0]['value']['#disabled'] = !$this->entity->isNew();
    $form['machine_name']['widget'][0]['value']['#machine_name']['source'] = [
      'name',
    ];
    $form['machine_name']['widget'][0]['value']['#machine_name']['exists'] = [
      $this,
      'exists',
    ];
    $form['name']['widget'][0]['value']['#field_suffix'] = '<span id="edit-name-wrapper-machine-name-suffix"></span>';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;
    $palette = $form_state->getValue('settings')[0]['color']['palette'];
    $def_palette = color_get_palette($entity->getParentMachineName(), TRUE);
    $output = '';
    if (implode(',', $def_palette) != implode(',', $palette)) {
      $current_module_path = \Drupal::service('module_handler')->getModule('openedu_subtheme')->getPath();
      $def_content = file_get_contents($current_module_path . '/css/colors.css');
      $output = $def_content;
      foreach ($palette as $p_key => $color) {
        if ($def_palette[$p_key] != $color) {
          $output = str_replace($def_palette[$p_key], $color, $output);
        }
      }
    }
    // Custom css to output.
    $custom_css = $entity->custom_css->value;
    if (!empty($custom_css)) {
      $output .= PHP_EOL . $custom_css;
    }

    if (!empty($output)) {
      $dir = 'public://openedu_subtheme';
      $dir_css = $dir . '/css';

      file_prepare_directory($dir, FILE_CREATE_DIRECTORY);
      file_prepare_directory($dir_css, FILE_CREATE_DIRECTORY);
      file_unmanaged_save_data($output, $dir_css . '/' . $entity->id() . '.css', FILE_EXISTS_REPLACE);
    }
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Subtheme Entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Subtheme Entity.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.subtheme_entity.canonical', ['subtheme_entity' => $entity->id()]);
  }

  /**
   * Check if Entity exist.
   */
  public function exists($value, $element, $form_state) {
    $entities = \Drupal::entityQuery('subtheme_entity')->condition('machine_name', $value)->execute();

    return !empty($entities);
  }

}
