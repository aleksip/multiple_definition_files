<?php

namespace Drupal\multiple_definition_files\Theme;

use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Layout\LayoutDefinition;
use Drupal\Core\Layout\LayoutPluginManagerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\multiple_definition_files\Plugin\Discovery\RecursiveMergedYamlDiscovery;

/**
 * Multiple layout discovery service.
 */
class MultipleLayoutDiscovery implements MultipleLayoutDiscoveryInterface {

  /**
   * The theme handler service.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * The layout plugin manager service.
   *
   * @var \Drupal\Core\Layout\LayoutPluginManagerInterface
   */
  protected $layoutPluginManager;

  /**
   * MultipleLayoutsDiscovery constructor.
   *
   * @param \Drupal\Core\Layout\LayoutPluginManagerInterface $layout_plugin_manager
   *   The layout plugin manager service.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler service.
   */
  public function __construct(
    LayoutPluginManagerInterface $layout_plugin_manager,
    ThemeHandlerInterface $theme_handler
  ) {
    $this->layoutPluginManager = $layout_plugin_manager;
    $this->themeHandler = $theme_handler;
  }

  /**
   * {@inheritdoc}
   */
  public function getThemeLayouts($exclude = FALSE) {
    return $this->getLayouts($this->themeHandler->getThemeDirectories(), $exclude);
  }

  /**
   * {@inheritdoc}
   */
  public function addThemeLayouts(array &$layouts) {
    $layouts = array_merge($layouts, $this->getThemeLayouts(TRUE));
  }

  /**
   * Returns layout definitions found in a set of directories.
   *
   * @param array $directories
   *   An array of directories to scan, keyed by the provider.
   * @param bool $exclude
   *   Whether to exclude the main definition file or not. Defaults to FALSE.
   *
   * @return array
   *   An array of layout definitions, keyed by plugin ID.
   */
  public function getLayouts(array $directories, $exclude = FALSE) {
    $layouts = [];
    $discovery = new RecursiveMergedYamlDiscovery(
      $directories, 'layouts', 'layouts', $exclude
    );
    $definitions = $discovery->getDefinitions();
    foreach ($definitions as $definition) {
      if (!isset($definition['class'])) {
        $definition['class'] = LayoutDefault::class;
      }
      $definition = new LayoutDefinition($definition);
      if ($this->layoutPluginManager instanceof DefaultPluginManager) {
        $this->layoutPluginManager->processDefinition($definition, $definition->id());
      }
      $layouts[$definition->id()] = $definition;
    }
    return $layouts;
  }

}
