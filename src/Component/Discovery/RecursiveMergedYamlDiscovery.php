<?php

namespace Drupal\multiple_definition_files\Component\Discovery;

/**
 * Recursively discovers and merges multiple YAML files in a set of directories.
 */
class RecursiveMergedYamlDiscovery extends RecursiveYamlDiscovery {

  /**
   * Whether to exclude the main definition file or not.
   *
   * @var bool
   */
  protected $exclude;

  /**
   * MergeYamlDirectoryDiscovery constructor.
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
    parent::__construct($directories, $file_cache_key_suffix, $name);
    $this->exclude = $exclude;
  }

  /**
   * {@inheritdoc}
   */
  public function findAll() {
    $all = parent::findAll();
    $merged = [];
    foreach ($all as $provider => $files) {
      $merged[$provider] = [];
      foreach ($files as $id => $data) {
        if ($this->exclude && $id == $provider) {
          continue;
        }
        unset($data[static::FILE_KEY]);
        $merged[$provider] = array_merge($merged[$provider], $data);
      }
    }
    return $merged;
  }

}
