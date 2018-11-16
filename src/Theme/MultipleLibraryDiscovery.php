<?php

namespace Drupal\multiple_definition_files\Theme;

use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\multiple_definition_files\Plugin\Discovery\RecursiveMergedYamlDiscovery;

/**
 * Multiple library discovery service.
 */
class MultipleLibraryDiscovery implements MultipleLibraryDiscoveryInterface {

  /**
   * The theme handler service.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * MultipleLibrariesDiscovery constructor.
   *
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler service.
   */
  public function __construct(ThemeHandlerInterface $theme_handler) {
    $this->themeHandler = $theme_handler;
  }

  /**
   * {@inheritdoc}
   */
  public function getThemeLibraries($exclude = FALSE) {
    return $this->getLibraries($this->themeHandler->getThemeDirectories(), $exclude);
  }

  /**
   * {@inheritdoc}
   */
  public function addThemeLibraries(array &$libraries, $extension) {
    if ($this->themeHandler->themeExists($extension)) {
      $theme = $this->themeHandler->getTheme($extension);
      $libraries = array_merge($libraries, $this->getLibraries([$theme->getName() => $theme->getPath()], TRUE));
    }
  }

  /**
   * Returns library definitions found in a set of directories.
   *
   * @param array $directories
   *   An array of directories to scan, keyed by the provider.
   * @param bool $exclude
   *   Whether to exclude the main definition file or not. Defaults to FALSE.
   *
   * @return array
   *   An associative array of libraries found. Keyed by internal library name.
   */
  protected function getLibraries(array $directories, $exclude = FALSE) {
    $discovery = new RecursiveMergedYamlDiscovery(
      $directories, 'libraries', 'libraries', $exclude
    );
    return $discovery->getDefinitions();
  }

}
