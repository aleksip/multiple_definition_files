<?php

namespace Drupal\multiple_definition_files\Component\Discovery;

/**
 * Filters out directories during the iteration.
 */
class RecursiveIgnoreDirectoriesFilterIterator extends \RecursiveFilterIterator {

  /**
   * List of directory names to skip when recursing.
   *
   * @var array
   */
  protected $ignoreDirectories = [];

  /**
   * IgnoreDirectoriesRecursiveFilterIterator constructor.
   *
   * @param \RecursiveIterator $iterator
   *   The iterator to filter.
   * @param array $ignore_directories
   *   Directories that should be filtered out during the iteration.
   */
  public function __construct(\RecursiveIterator $iterator, array $ignore_directories = []) {
    parent::__construct($iterator);
    $this->ignoreDirectories = array_merge($this->ignoreDirectories, $ignore_directories);
  }

  /**
   * {@inheritdoc}
   */
  public function getChildren() {
    $filter = parent::getChildren();
    $filter->ignoreDirectories = $this->ignoreDirectories;
    return $filter;
  }

  /**
   * {@inheritdoc}
   */
  public function accept() {
    if ($this->isDir()) {
      $name = $this->current()->getFilename();
      return !in_array($name, $this->ignoreDirectories, TRUE);
    }
    return TRUE;
  }

}
