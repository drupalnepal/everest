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
}
