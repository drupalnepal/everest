<?php

/**
 * @file
 * theme-settings.php
 * 
 * Theme setting callbacks for the "Everest" theme.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 */
function everest_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes.
  // @see https://drupal.org/node/943212
  if (isset($form_id)) {
    return;
  }

  // Theme settings.
  $form['theme-settings'] = array(
    '#type' => 'vertical_tabs',
    '#prefix' => '<h2>' . t('Theme Settings') . '</h2>',
    '#attached' => array(
      'js' => array(
        drupal_get_path('theme', 'everest') . '/js/everest.admin.js' => array(
          'type' => 'file',
        ),
      ),
    ),
  );

  // General theme settings.
  $form['general'] = array(
    '#group' => 'theme-settings',
    '#type' => 'fieldset',
    '#title' => t('General settings'),
  );
  $form['theme_settings']['#group'] = 'general';
  $form['logo']['#group'] = 'general';
  $form['favicon']['#group'] = 'general';

  // Everest theme settings.
  $form['everest'] = array(
    '#group' => 'theme-settings',
    '#type' => 'fieldset',
    '#title' => t('Everest settings'),
  );

  // Development settings.
  $form['development'] = array(
    '#group' => 'theme-settings',
    '#type' => 'fieldset',
    '#title' => t('Development'),
  );
  $form['development']['everest_region_debug'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show regions'),
    '#description' => t('Show all regions for debugging purpose.'),
    '#default_value' => theme_get_setting('everest_region_debug'),
  );
}
