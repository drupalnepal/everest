<?php

/**
 * @file
 * everest.drush.inc
 */

/**
 * Implements hook_drush_command().
 */
function everest_drush_command() {
  $items['everest-subtheme'] = array(
    'description' => dt('Creates a sub-theme using Everest base theme.'),
    'aliases' => array('est'),
  );

  return $items;
}

/**
 * Callback for the everest-subtheme command.
 */
function drush_everest_subtheme() {
  // Prompt for human readable sub-theme's name.
  $name = drush_prompt(dt('Please enter the human readable name of the new sub-theme'), dt('Everest sub-theme'));

  // Prompt for human readable sub-theme's description.
  $description = drush_prompt(dt('Please enter the description of the new sub-theme'), dt('A sub-theme of Everest base theme for Drupal 7.'));

  // Generate machine-readable name from sub-theme's name.
  $machine_name = _everest_generate_machine_name($name);

  // Continuously prompt for machine-readable name until it succeeds.
  drush_set_option('machine-name', _everest_verify_machine_name(dt('Please enter a machine-readable name for the new sub-theme'), $machine_name));
  $machine_name = drush_get_option('machine-name');

  // Prompt for path to new sub-theme.
  $subtheme_path = drush_prompt(dt('Please enter destination path where you want to place the new sub-theme.'), 'sites/all/themes');
  drush_set_option('subtheme_path', $subtheme_path);

  // Check whether the destination path exists or not.
  $subtheme_path = drush_get_option('subtheme_path', 'sites/all/themes');
  $subtheme_path = drush_trim_path($subtheme_path);
  $subtheme_path = drush_normalize_path(drush_get_context('DRUSH_DRUPAL_ROOT') . '/' . $subtheme_path . '/' . $machine_name);
  if (file_exists($subtheme_path)) {
    return drush_set_error('EVEREST_SUBTHEME_PATH', dt('The path @path already exists.', array('@path' => $subtheme_path)));
  }

  $starterkit_path = drush_normalize_path(drush_get_context('DRUSH_DRUPAL_ROOT') . '/' . drupal_get_path('theme', 'everest') . '/STARTERKIT');
  $starterkit_info_file = $starterkit_path . '/' . 'STARTERKIT.info.txt';

  // Copy all the STARTERKIT files to a new sub-theme directory and rename all files and strings.
  if (!drush_copy_dir($starterkit_path, $subtheme_path)) {
    return drush_set_error('EVEREST_STARTERKIT_COPY', dt('Failed to copy STARTERKIT files to a new sub-theme.'));
  }

  // Rename .info file.
  $subtheme_info_file = $subtheme_path . '/' . $machine_name . '.info';
  drush_op('rename', $subtheme_path . '/STARTERKIT.info.txt', $subtheme_info_file);

  // Get the information stored in theme's .info file.
  $subtheme_info = drupal_parse_info_file($subtheme_info_file);

  // Alter the contents of the .info file.
  $search_replace = array(
    $subtheme_info['name'] => $name,
    $subtheme_info['description'] => $description,
    'STARTERKIT' => $machine_name,
  );

  drush_op('_everest_recursive_search_replace', $subtheme_path, array_keys($search_replace), array_values($search_replace));

  // Notify user of the newly created sub-theme.
  drush_log(dt('A new sub-theme "@theme" (@name) has been successfully created in @path.', array(
    '@theme' => $name,
    '@name' => $machine_name,
    '@path' => $subtheme_path,
  )), 'success');
}

/**
 * Generate machine-readable name from sub-theme's name.
 */
function _everest_generate_machine_name($name) {
  // The machine-readable name must start with a lowercase letter.
  $machine_name = preg_replace('/^[^a-z]+/', '', strtolower($name));

  // The machine-readable name must contain only lowercase letters, numbers,
  // and underscores.
  $machine_name = preg_replace('/[^a-z0-9_]+/', '_', $machine_name);

  // Trim all trailing and leading underscores.
  $machine_name = trim($machine_name, '_');

  $themes = list_themes();
  if (isset($themes[$machine_name])) {
    $plain = $machine_name;
    $counter = 0;

    while (isset($themes[$machine_name])) {
      // Append counter to make the machine-readable name unique.
      $machine_name = $plain . '_' . $counter++;
    }
  }

  return $machine_name;
}

/**
 * Prompt and verify sub-theme's machine-readable name.
 */
function _everest_verify_machine_name($message, $default = NULL) {
  while (TRUE) {
    // Prompt for new sub-theme's machine-readable name.
    $machine_name = drush_prompt($message, $default);

    if (!preg_match('/^[a-z][a-z0-9_]*$/', $machine_name)) {
      drush_print('The machine-readable name is invalid. It must contain only lowercase letters, numbers, and underscores and must start with a letter.');
    }
    else {
      $themes = list_themes();
      // Verify that the machine name is unique.
      if (isset($themes[$machine_name])) {
        drush_print(dt('A theme with the name @name already exists. The machine-readable name must be unique.', array(
          '@name' => $machine_name,
        )));
      }
      else {
        return $machine_name;
      }
    }
  }
}

/**
 * Helper function to replace strings inside the file.
 */
function _everest_str_replace($file_path, $find, $replace) {
  $file_path = drush_normalize_path($file_path);
  $file_contents = file_get_contents($file_path);
  $file_contents = str_replace($find, $replace, $file_contents);
  file_put_contents($file_path, $file_contents);
}

/**
 * Helper function to recursively search all files, rename it and replace strings.
 */
function _everest_recursive_search_replace($path, $search, $replace) {
  $exclude = array(
    'filename' => array(
      '.DS_Store',
    ),
    'extension' => array(
      'png',
      'jpg',
      'ico',
    ),
  );

  $directory = new DirectoryIterator($path);

  foreach ($directory as $item) {
    if ($item->isDot() || in_array($item->getFileName(), $exclude['filename']) || in_array($item->getExtension(), $exclude['extension'])) {
      continue;
    }

    // Retrieve the path of the current item.
    $path_name = $item->getPathname();

    // Recursively search and replace string inside a file.
    if ($item->isDir()) {
      _everest_recursive_search_replace($path_name, $search, $replace);
    }
    elseif ($item->isFile()) {
      _everest_str_replace($path_name, $search, $replace);

      // Rename filename.
      if (strstr($item->getFileName(), 'STARTERKIT')) {
        $path_name_renamed = $item->getPath() . '/' . str_replace($search, $replace, $item->getFileName());
        drush_op('rename', $path_name, $path_name_renamed);
      }
    }
  }

  return TRUE;
}

/**
 * Implements hook_drush_help().
 */
function everest_drush_help($section) {
  switch ($section) {
    case 'drush:everest-subtheme':
      return dt('Creates a sub-theme using Everest base theme.');
  }
}
