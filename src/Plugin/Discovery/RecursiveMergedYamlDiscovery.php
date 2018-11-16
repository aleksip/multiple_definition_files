<?php

namespace Drupal\multiple_definition_files\Plugin\Discovery;

use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\multiple_definition_files\Component\Discovery\RecursiveMergedYamlDiscovery as ComponentRecursiveMergedYamlDiscovery;

/**
 * Recursively discovers and merges multiple YAML files in a set of directories.
 */
class RecursiveMergedYamlDiscovery extends YamlDiscovery {

  /**
   * RecursiveYamlDirectoryDiscovery constructor.
   *
   * @param array $directories
   *   An array of directories to scan, keyed by the provider. The value can
   *   either be a string or an array of strings. The string values should be
   *   the path of a directory to scan.
   * @param string $file_cache_key_suffix
   *   The file cache key suffix. This should be unique for each type of
   *   discovery.
   * @param string $name
   *   Optional base filename to look for in each directory. The format will be
   *   $name.yml.
   * @param bool $exclude
   *   Whether to exclude the main definition file or not. Defaults to FALSE.
   */
  public function __construct(array $directories, $file_cache_key_suffix, $name = '', $exclude = FALSE) {
    // Intentionally does not call parent constructor as this class uses a
    // different YAML discovery.
    $this->discovery = new ComponentRecursiveMergedYamlDiscovery($directories, $file_cache_key_suffix, $name, $exclude);
  }

}
