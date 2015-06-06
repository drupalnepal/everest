<?php

/**
 * @file
 * template.php
 */

/**
 * Auto-rebuild the theme registry during theme development.
 */
if (theme_get_setting('everest_rebuild_registry') && !defined('MAINTENANCE_MODE')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

/**
 * Implements hook_preprocess_html().
 */
function everest_preprocess_html(&$variables) {
  if (theme_get_setting('everest_region_debug') == 1) {
    $path = drupal_get_path('theme', 'everest');
    drupal_add_css($path . '/css/everest.development.css', array(
      'group' => CSS_THEME,
      'weight' => -10,
      'every_page' => TRUE,
    ));
  }
}

/**
 * Implements hook_preproces_region().
 */
function everest_preprocess_region(&$variables) {
  if (theme_get_setting('everest_region_debug') == 1 && $variables['debug'] = !empty($variables['elements']['#debug'])) {
    $class = drupal_html_class('region--debug--' . $variables['region']);

    drupal_add_css(".$class:before { content: \"{$variables['elements']['#name']}\"; }", array(
      'type' => 'inline',
      'group' => CSS_THEME,
      'weight' => 1000,
    ));

    $variables['classes_array'][] = 'region--debug';
    $variables['classes_array'][] = $class;

    // Ensure that the content is not completely empty.
    $variables['content'] = !empty($variables['content']) ? $variables['content'] : '&nbsp;';
  }
}

/**
 * Implements hook_html_head_alter().
 */
function everest_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => str_replace('text/html; charset=', '', $head_elements['system_meta_content_type']['#attributes']['content']),
  );
}

/**
 * Implements hook_page_alter().
 */
function everest_page_alter(&$page) {
  if (theme_get_setting('everest_region_debug') == 1 && user_access('administer site configuration')) {
    $item = menu_get_item();

    // Don't interfere with the 'Demonstrate block regions' page.
    if (strpos($item['path'], 'admin/structure/block/demo/') !== 0) {
      // Get a list of available visible regions from 'Everest' theme.
      $regions = system_region_list($GLOBALS['theme_key'], REGIONS_VISIBLE);

      foreach ($regions as $region => $name) {
        if (empty($page[$region])) {
          $page[$region]['#theme_wrappers'] = array('region');
          $page[$region]['#region'] = $region;
        }

        $page[$region]['#name'] = $name;
        $page[$region]['#debug'] = TRUE;
      }
    }
  }
}
