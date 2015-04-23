<?php

/**
 * @file
 * template.php
 */

/**
 * Implements hook_library().
 *
 * Registers JavaScript/CSS libraries.
 */
function drupalnepal_theme_library() {
  $libraries = array();

  // Path to theme.
  $theme_path = drupal_get_path('theme', 'drupalnepal_theme');

  // Main library.
  $libraries['main'] = array(
    'title' => t('Drupal Nepal Theme'),
    'website' => 'http://www.drupalnepal.com',
    'version' => '1.0',
    'js' => array(
      $theme_path . '/assets/js/drupalnepal_theme.js' => array(
        'type' => 'file',
        'scope' => 'footer',
        'group' => JS_THEME,
        'weight' => 1,
        'every_page' => TRUE,
      ),
    ),
    'css' => array(
      $theme_path . '/assets/css/style.css' => array(
        'type' => 'file',
        'scope' => 'header',
        'group' => CSS_THEME,
        'weight' => 1,
        'every_page' => TRUE,
      ),
    ),
    'dependencies' => array(),
  );

  return $libraries;
}

/**
 * Implements hook_preprocess_html().
 */
function drupalnepal_theme_preprocess_html(&$variables) {
  // Load the 'main' library.
  // drupal_add_library('drupalnepal_theme', 'main', TRUE);
}
