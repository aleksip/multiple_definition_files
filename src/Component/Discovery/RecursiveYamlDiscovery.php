<?php

namespace Drupal\multiple_definition_files\Component\Discovery;

use Drupal\Component\Discovery\YamlDirectoryDiscovery;
use Drupal\Core\Site\Settings;

/**
 * Recursively discovers multiple YAML files in a set of directories.
 */
class RecursiveYamlDiscovery extends YamlDirectoryDiscovery {

  /**
   * The base filename to look for in each directory.
   *
   * @var string
   */
  protected $name;

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
   */
  public function __construct(array $directories, $file_cache_key_suffix, $name = '') {
    parent::__construct($directories, $file_cache_key_suffix);
    $this->name = $name;
  }

  /**
   * {@inheritdoc}
   */
  protected function getIdentifier($file, array $data) {
    $name = $this->name;
    if ($name !== '') {
      $name = '.' . $name;
    }
    return basename($file, $name . '.yml');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDirectoryIterator($directory) {
    $name = $this->name;
    if ($name !== '') {
      $name = '\.' . $name;
    }
    $flags = \FilesystemIterator::UNIX_PATHS;
    $flags |= \FilesystemIterator::SKIP_DOTS;
    $flags |= \FilesystemIterator::FOLLOW_SYMLINKS;
    $flags |= \FilesystemIterator::CURRENT_AS_SELF;
    $iterator = new \RecursiveDirectoryIterator($directory, $flags);
    $ignore_directories = Settings::get('file_scan_ignore_directories', []);
    $iterator = new RecursiveIgnoreDirectoriesFilterIterator($iterator, $ignore_directories);
    $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
    $iterator = new \RegexIterator($iterator, '/' . $name . '\.yml$/i');
    return $iterator;
  }

}
