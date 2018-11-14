<?php

namespace Drupal\multiple_definition_files\Theme;

/**
 * Multiple library discovery interface.
 */
interface MultipleLibraryDiscoveryInterface {

  /**
   * Returns libraries defined in active themes.
   *
   * @param bool $exclude
   *   Whether to exclude the main definition file or not. Defaults to FALSE.
   *
   * @return array
   *   An associative array of libraries in active themes. Keyed by
   *   internal library name.
   */
  public function getThemeLibraries($exclude = FALSE);

  /**
   * Adds additional libraries if the extension is an enabled theme.
   *
   * @param array $libraries
   *   An associative array of libraries registered by $extension. Keyed by
   *   internal library name and passed by reference.
   * @param string $extension
   *   Can either be 'core' or the machine name of the extension that registered
   *   the libraries.
   */
  public function addThemeLibraries(array &$libraries, $extension);

}
