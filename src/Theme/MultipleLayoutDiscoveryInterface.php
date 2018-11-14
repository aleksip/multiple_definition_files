<?php

namespace Drupal\multiple_definition_files\Theme;

/**
 * Multiple layout discovery interface.
 */
interface MultipleLayoutDiscoveryInterface {

  /**
   * Returns layouts defined in active themes.
   *
   * @param bool $exclude
   *   Whether to exclude the main definition file or not. Defaults to FALSE.
   *
   * @return array
   *   An array of layout definitions, keyed by plugin ID.
   */
  public function getThemeLayouts($exclude = FALSE);

  /**
   * Adds additional layouts from all installed themes.
   *
   * @param array $layouts
   *   An array of layout definitions, keyed by plugin ID.
   */
  public function addThemeLayouts(array &$layouts);

}
