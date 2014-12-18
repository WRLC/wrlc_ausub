<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

/**
 * Implements hook preprocess_page().
 *
 * Hook implementation is used to provide style
 * overrides on a multi-site basis. Targed
 * multisites include:
 *
 * muislandora.wrlc.org
 * auislandora.wrlc.org
 * cuislandora.wrlc.org
 * dcislandora.wrlc.org
 * gaislandora.wrlc.org
 *
 * @param array $vars
 *   An array of available page level variables.
 */
function wrlc_primary_preprocess_page(&$vars) {
  $site = $_SERVER['HTTP_HOST'];
  drupal_add_css(path_to_theme() . '/css/muislandora.css', 'theme', 'all');

  // Switch on site host to provide applicable CSS.
  switch ($site) {
    case 'auislandora.wrlc.org':
      $vars['logo'] = url(path_to_theme() . "/images/multisite_logos/Digital-Research-Portal-header.png");
      $vars['site_name'] = "";
      drupal_add_css(path_to_theme() . '/css/auislandora.css', 'theme', 'all');
      break;
    case 'dcislandora.wrlc.org':
      $vars['logo'] = url(path_to_theme() . "/images/multisite_logos/dcislandora_logo.png");
      $vars['site_name'] = "";
      drupal_add_css(path_to_theme() . '/css/dcislandora.css', 'theme', 'all');
      break;
    case 'cuislandora.wrlc.org':
      $vars['logo'] = url(path_to_theme() . "/images/multisite_logos/cuislandora-logo.png");
      $vars['site_name'] = "Digital Collections";
      $vars['site_slogan'] = "University Libraries";
      drupal_add_css(path_to_theme() . '/css/cuislandora.css', 'theme', 'all');
      break;
    case 'gaislandora.wrlc.org':
      $vars['logo'] = url(path_to_theme() . "/images/multisite_logos/gaislandora_logo.png");
      $vars['site_name'] = "The University Library Archives";
      $vars['site_slogan'] = "";
      drupal_add_css(path_to_theme() . '/css/gaislandora.css', 'theme', 'all');
      break;
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function wrlc_primary_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' › ', $breadcrumb['breadcrumb']) .'</div>';
  }
}

/**
 * Override or insert variables into the islandora templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function wrlc_primary_menu_local_tasks_alter(&$data, $router_item, $root_path) {
  if (strpos($root_path, 'islandora/object/%') === 0) {
    if (isset($data['tabs'][0]['output'])) {
      foreach ($data['tabs'][0]['output'] as $key => &$tab) {
        if ($tab['#link']['path'] == 'islandora/object/%/print_object') {
          if ($root_path == 'islandora/object/%') {
            $tab['#prefix'] = '<li class="tabs-primary__tab">';
            $tab['#text'] = t('Print');
            $tab['#options']['attributes']['class'] = array("tabs-primary__tab-link");
          }
        }
      }
    }
  }
}
