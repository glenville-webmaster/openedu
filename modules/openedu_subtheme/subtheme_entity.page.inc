<?php

/**
 * @file
 * Contains subtheme_entity.page.inc.
 *
 * Page callback for Subtheme Entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Subtheme Entity templates.
 *
 * Default template: subtheme_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_subtheme_entity(array &$variables) {
  // Fetch SubthemeEntity Entity Object.
  $subtheme_entity = $variables['elements']['#subtheme_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
