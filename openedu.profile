<?php

/**
 * @file
 * Profile file for OpenEDU distribution.
 */

use Drupal\openedu\Form\CheckLingotek;

/**
 * Implements hook_install_tasks().
 */
function openedu_install_tasks() {
  return [
    'openedu_check_lingotek' => [
      'display_name' => t('Lingotek Integration'),
      'display' => TRUE,
      'type' => 'form',
      'function' => CheckLingotek::class,
    ],
    'openedu_enabling_lingotek' => [
      'type' => 'batch',
    ],
  ];
}

/**
 * Enable Lingotek module.
 *
 * @param array $install_state
 *   Installation parameters.
 *
 * @return array
 *   Batch.
 */
function openedu_enabling_lingotek(array &$install_state) {
  if (!empty($install_state['openedu']['lingotek'])) {
    $service = \Drupal::service('module_installer');
    $service->install(['lingotek']);
  }

  return ['operations' => []];
}
