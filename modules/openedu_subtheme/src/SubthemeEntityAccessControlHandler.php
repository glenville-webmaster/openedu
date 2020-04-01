<?php

namespace Drupal\openedu_subtheme;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Subtheme Entity entity.
 *
 * @see \Drupal\openedu_subtheme\Entity\SubthemeEntity.
 */
class SubthemeEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\openedu_subtheme\Entity\SubthemeEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished subtheme entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published subtheme entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit subtheme entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete subtheme entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add subtheme entity entities');
  }

}
