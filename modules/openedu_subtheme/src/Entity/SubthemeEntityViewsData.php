<?php

namespace Drupal\openedu_subtheme\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Subtheme Entity entities.
 */
class SubthemeEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins,
    // can be put here.
    return $data;
  }

}
