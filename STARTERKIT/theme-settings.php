<?php

/**
 * @file
 * theme-settings.php
 *
 * Theme setting callbacks for the "STARTERKIT" theme.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 */
function STARTERKIT_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL) {
  $form['everest']['STARTERKIT_libraries'] = array(
    '#type' => 'fieldset',
    '#title' => t('JavaScript Libraries'),
    '#collapsible' => TRUE,
  );
  $form['everest']['STARTERKIT_libraries']['STARTERKIT_libraries_modernizr'] = array(
    '#type' => 'checkbox',
    '#title' => t('Modernizr'),
    '#description' => t('Check here to enable Modernizr.'),
    '#default_value' => theme_get_setting('STARTERKIT_libraries_modernizr'),
  );
}
