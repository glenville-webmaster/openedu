<?php

namespace Drupal\openedu_subtheme\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface for defining Subtheme Entity entities.
 *
 * @ingroup openedu_subtheme
 */
interface SubthemeEntityInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Gets the Subtheme Entity name.
   *
   * @return string
   *   Name of the Subtheme Entity.
   */
  public function getName();

  /**
   * Sets the Subtheme Entity name.
   *
   * @param string $name
   *   The Subtheme Entity name.
   *
   * @return \Drupal\openedu_subtheme\Entity\SubthemeEntityInterface
   *   The called Subtheme Entity entity.
   */
  public function setName($name);

  /**
   * Gets the Subtheme Entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Subtheme Entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Subtheme Entity creation timestamp.
   *
   * @param int $timestamp
   *   The Subtheme Entity creation timestamp.
   *
   * @return \Drupal\openedu_subtheme\Entity\SubthemeEntityInterface
   *   The called Subtheme Entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Subtheme Entity published status indicator.
   *
   * Unpublished Subtheme Entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Subtheme Entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Subtheme Entity.
   *
   * @param bool $published
   *   TRUE to set this Subtheme Entity to published,
   *   FALSE to set it to unpublished.
   *
   * @return \Drupal\openedu_subtheme\Entity\SubthemeEntityInterface
   *   The called Subtheme Entity entity.
   */
  public function setPublished($published);

}
