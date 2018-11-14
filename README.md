# Multiple Definition Files

This Drupal 8 module enables multiple definition files for theme [asset libraries](https://www.drupal.org/docs/8/theming/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-theme) and [layouts](https://www.drupal.org/docs/8/api/layout-api/how-to-register-layouts).


## Installing

Install and enable just like any other Drupal module. No configuration required.


## Motivation

One of the principles in Twig component based theme development is that all files related to a particular component should be located in a component specific folder. However, currently Drupal core only supports extension (theme) specific definition files for asset libraries and templates. This module enables component specific definition files to be located in component folders.


## How it works

The theme folder of the default theme is recursively scanned for definition files. All found definitions are then merged into the existing/a new main theme definition file using [`hook_library_info_alter()`](https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Render!theme.api.php/function/hook_library_info_alter) and [`hook_layout_alter()`](https://api.drupal.org/api/drupal/core!core.api.php/function/hook_layout_alter). From the perspective of Drupal core, everything should work just the same as if all definitions were in the main theme specific file.


## Notes on layout templates

Please note that the templates defined in `.layout.yml` files should use the `.html.twig` suffix.

The contents of regions defined in `.layout.yml` files are by default accessible in Twig templates under the `content` variable. So the contents of a `main` region would be displayed with `{{ content.main }}`. To aid in creating less Drupal specific component templates, this module also makes layout region variables available in the Twig context root. This makes it also possible to use just `{{ main }}`. The module will not overwrite existing variables. This means that defining a `content` region should probably be avoided, as that would have to be displayed with `{{ content.content }}`.


## Warning

This is an experimental module. The approach used might not be a good one, and might cause unforeseen issues. Use at your own risk.
