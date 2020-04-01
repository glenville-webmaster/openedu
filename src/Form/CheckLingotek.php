<?php

namespace Drupal\openedu\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a form for enabling Lingotek module.
 */
class CheckLingotek extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'openedu_check_lingotek';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, array &$install_state = NULL) {
    $form['#title'] = $this->t('Lingotek Integration');

    $drupal_project = Url::fromUri("https://www.drupal.org/project/lingotek")->toString();
    $lingotek_link = Url::fromUri("https://www.lingotek.com")->toString();
    $form['markup'] = [
      '#markup' => '<p>' . $this->t('Multilingual made easy by <a target="_blank" href="@lingotek">Lingotek</a>.', ['@lingotek' => $lingotek_link]) . '</p>' . '<p>' . $this->t('Content and Configuration Translation in minutes! Check out the <a target="_blank" href="@drupal">Lingotek Module Page</a> for more information.', ['@drupal' => $drupal_project]) . '</p>',
      '#allowed_tags' => ['p', 'a'],
    ];

    $form['checkbox'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Lingotek'),
      '#default_value' => 0,
    ];

    $form['actions'] = [
      'continue' => [
        '#type' => 'submit',
        '#value' => $this->t('Continue'),
      ],
      '#type' => 'actions',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $GLOBALS['install_state']['openedu']['lingotek'] = $form_state->getValue('checkbox');
  }

}
