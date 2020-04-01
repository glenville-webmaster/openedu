<?php

namespace Drupal\openedu_subtheme;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Path\AliasManager;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Path\PathMatcherInterface;
use Drupal\openedu_subtheme\Entity\SubthemeEntityInterface;

/**
 * Class SubthemeVisibilityService.
 */
class SubthemeVisibilityService {

  protected $pathMatcher;

  protected $currentPath;

  protected $aliasManager;

  /**
   * Constructs a new SubthemeVisibilityService object.
   */
  public function __construct(PathMatcherInterface $pathMatcher, CurrentPathStack $currentPath, AliasManager $aliasManager) {
    $this->pathMatcher = $pathMatcher;
    $this->currentPath = $currentPath;
    $this->aliasManager = $aliasManager;
  }

  /**
   * Helper for defining if shown on current page.
   */
  public function visibilityAccess(SubthemeEntityInterface $entity) {
    $pages = '';
    if ($entity->hasField('field_pages')) {
      $pages = $entity->get('field_pages')->value;
    }

    $state = 'include';
    if ($entity->hasField('field_pages_option')) {
      $state = $entity->get('field_pages_option')->value;
    }

    $pages = Unicode::strtolower($pages);
    if (!$pages) {
      return FALSE;
    }

    $path_matcher = $this->pathMatcher;

    // Convert path to lowercase. This allows comparison of the same path.
    // with different case. Ex: /Page, /page, /PAGE.
    // Compare the lowercase path alias (if any) and internal path.
    $current_path = $this->currentPath->getPath();
    $path = $this->aliasManager->getAliasByPath($current_path);
    $path = Unicode::strtolower($path);

    // Do not trim a trailing slash if that is the complete path.
    $path = $path === '/' ? $path : rtrim($path, '/');

    $is_path_match = $path_matcher->matchPath($path, $pages);
    if ($state == 'include' && $is_path_match || $state == 'exclude' && !$is_path_match) {
      return TRUE;
    }

    return FALSE;
  }

}
