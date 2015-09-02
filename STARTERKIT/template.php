<?php

/**
 * @file
 * template.php
 */

/**
 * Preprocess variables for page.tpl.php template file.
 */
function STARTERKIT_preprocess_page(&$variables) {
  $development_mode = theme_get_setting('everest_development_mode');
  $theme_path = drupal_get_path('theme', 'STARTERKIT') . '/';

  if ($development_mode === 1) {
    $css_path = $theme_path . 'assets/dev/css/';
    $js_path = $theme_path . 'assets/dev/js/';
  }
  else {
    $css_path = $theme_path . 'css/';
    $js_path = $theme_path . 'js/';
  }

  // Add Modernizr.
  if (theme_get_setting('STARTERKIT_libraries_modernizr') === 1) {
    // If weight >= -1 or 'every_page = FALSE', it will show
    // duplicate class 'js' inside the html tag.
    drupal_add_js($js_path . 'libraries/modernizr.js', array(
      'scope' => 'header',
      'group' => JS_LIBRARY,
      'weight' => -22,
      'every_page' => TRUE,
    ));
  }

  // Add main stylesheet.
  drupal_add_css($css_path . 'STARTERKIT_SANITIZED.styles.css', array(
    'type' => 'file',
    'group' => CSS_THEME,
    'every_page' => TRUE,
  ));
}
