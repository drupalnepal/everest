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
  $form['theme_settings']['#collapsible'] = TRUE;
  $form['theme_settings']['#collapsed'] = TRUE;
  $form['logo']['#group'] = 'general';
  $form['logo']['#collapsible'] = TRUE;
  $form['logo']['#collapsed'] = TRUE;
  $form['favicon']['#group'] = 'general';
  $form['favicon']['#collapsible'] = TRUE;
  $form['favicon']['#collapsed'] = TRUE;

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
  $form['development']['everest_development_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable development mode.'),
    '#description' => t('Check here to enable the development mode. Used for development purpose only.'),
    '#default_value' => theme_get_setting('everest_development_mode'),
  );
  $form['development']['everest_region_debug'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show regions.'),
    '#description' => t('Show all regions for debugging purpose.'),
    '#default_value' => theme_get_setting('everest_region_debug'),
  );
  $form['development']['everest_rebuild_registry'] = array(
    '#type' => 'checkbox',
    '#title' => t('Rebuild theme registry on every page.'),
    '#description'   => t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>.', array('!link' => 'https://drupal.org/node/173880#theme-registry')),
    '#default_value' => theme_get_setting('everest_rebuild_registry'),
  );
}
