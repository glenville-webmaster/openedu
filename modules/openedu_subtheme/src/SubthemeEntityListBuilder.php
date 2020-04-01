<?php

namespace Drupal\openedu_subtheme;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Subtheme Entity entities.
 *
 * @ingroup openedu_subtheme
 */
class SubthemeEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Subtheme Entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\openedu_subtheme\Entity\SubthemeEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.subtheme_entity.edit_form',
      ['subtheme_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
