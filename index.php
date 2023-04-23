<?php
/*
Plugin Name: Country Blocker for AdSense
Description: This is a quick and efficient solution for blocking ads from specific countries based on your preferences.
Author: Jesús Rodríguez
Author URI: https://support.google.com/profile/3384752
Version: 1.0
*/

if (!defined("ABSPATH")) die();

define("cbfa_PATH", plugin_dir_path(__FILE__));
define("cbfa_URI", plugin_dir_url(__FILE__));

function panel_cb_fa() {
	add_submenu_page(
		"options-general.php",
		"Country Blocker for AdSense",
		"Country Blocker for AdSense",
		"manage_options",
		"cb_fa",
		"cb_fa_html"
	);
}
add_action("admin_menu", "panel_cb_fa");

function cb_fa_html() {
	$settings = get_option('cbfa_settings');
	include cbfa_PATH . '/inc/admin-html.php';
}

function cbfa_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=cb_fa" title="Settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
$plugin_cbfa = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin_cbfa", "cbfa_settings_link");

function guardar_cbfa_ajax() {
	if(empty($_POST['trid']) || empty($_POST['toe']) || empty($_POST['apikeyfor'])) wp_die('false');

	$ajax_settings = array();

	$ajax_settings['id'] = $_POST['trid'];
	$ajax_settings['pais'] = $_POST['toe'];
	$ajax_settings['api_key'] = $_POST['apikeyfor'];
	$ajax_settings['save'] = time();

	update_option("cbfa_configured", "on");
	if(update_option('cbfa_settings', $ajax_settings)) wp_die('true');
}
add_action("wp_ajax_guardar_cbfa_AJAX", "guardar_cbfa_AJAX");

register_activation_hook(__FILE__, "on_cbfa_activate");
register_deactivation_hook(__FILE__, "on_cbfa_deactivate");
function on_cbfa_activate() {
	$settings = array(
		'id'    => '',
		'pais'  => '',
		'api_key'=>'',
	);
	add_option("cbfa_settings", $settings);
	add_option("cbfa_configured", "off");
}
function on_cbfa_deactivate() {
	delete_option("cbfa_settings");
	delete_option("cbfa_configured");
}

function show_cbfa_admin_notice(){
	$configured = get_option('cbfa_configured');
	if($configured !== 'on' && @$_GET['page'] !== 'cb_fa') {
    	echo '<div class="notice notice-error">
             <p>Hello, please finish setting up <strong>Country Blocker for AdSense</strong> by <a href="options-general.php?page=cb_fa" title="Settings">clicking here</a>.</p>
         </div>';
     }
}
add_action('admin_notices', 'show_cbfa_admin_notice');

// Agregar el código al head del sitio
function add_analytics_code() {
	$configured = get_option('cbfa_configured');
	$settings = get_option('cbfa_settings');
	if($configured === 'on') include cbfa_PATH . '/inc/header-html.php';
}
add_action('wp_head', 'add_analytics_code');
