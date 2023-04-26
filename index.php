<?php
/*
Plugin Name: Country Blocker for AdSense
Description: This is a quick and efficient solution for blocking ads from specific countries based on your preferences.
Author: Jesús Rodríguez
Author URI: https://support.google.com/profile/3384752
Version: 1.0
*/

if (!defined("ABSPATH")) {
    die();
}

define("CBFA_PATH", plugin_dir_path(__FILE__));
define("CBFA_URI", plugin_dir_url(__FILE__));

function CBFA_panel()
{
    add_submenu_page(
        "options-general.php",
        "Country Blocker for AdSense",
        "Country Blocker for AdSense",
        "manage_options",
        "CountryBlockerForAdSense",
        "CBFA_html"
    );
}
add_action("admin_menu", "CBFA_panel");

function CBFA_html()
{
    $settings = get_option("cbfa_settings");
    include CBFA_PATH . "/inc/admin-html.php";
}

function CBFA_settings_link($links)
{
    $settings_link =
        '<a href="options-general.php?page=CountryBlockerForAdSense" title="Settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin_cbfa = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin_cbfa", "CBFA_settings_link");

function CBFA_guardar_cbfa()
{
    if (
        empty($_POST["trid"]) ||
        empty($_POST["toe"]) ||
        empty($_POST["apikeyfor"])
    ) {
        wp_die("false");
    }

    $ajax_settings = [];
    
    $ajax_settings["id"] = wp_kses_post($_POST["trid"]);
    $ajax_settings["pais"] = wp_kses_post($_POST["toe"]);
    $ajax_settings["api_key"] = wp_kses_post($_POST["apikeyfor"]);

    
    $ajax_settings["save"] = time();

    update_option("cbfa_configured", "on");

    if (update_option("cbfa_settings", $ajax_settings)) {
        wp_die("true");
    }
}
add_action("wp_ajax_CBFA_guardar_cbfa", "CBFA_guardar_cbfa");

register_activation_hook(__FILE__, "CBFA_on__activate");
register_deactivation_hook(__FILE__, "CBFA_on__deactivate");
function CBFA_on__activate()
{
    $settings = [
        "id" => "",
        "pais" => "",
        "api_key" => "",
    ];
    add_option("cbfa_settings", $settings);
    add_option("cbfa_configured", "off");
}
function CBFA_on__deactivate()
{
    delete_option("cbfa_settings");
    delete_option("cbfa_configured");
}

function CBFA_show_admin_notice()
{
    $configured = get_option("cbfa_configured");
    if ($configured !== "on" && @$_GET["page"] !== "CountryBlockerForAdSense") {
        echo '<div class="notice notice-error">
<p>Hello, please finish setting up <strong>Country Blocker for AdSense</strong> by <a href="options-general.php?page=CountryBlockerForAdSense" title="Settings">clicking here</a>.</p>
</div>';
    }
}
add_action("admin_notices", "CBFA_show_admin_notice");

// Agregar el código al head del sitio
function CBFA_add_analytics_code()
{
    $configured = get_option("cbfa_configured");
    $settings = get_option("cbfa_settings");
    if ($configured === "on") {
        include CBFA_PATH . "/inc/header-html.php";
    }
}
add_action("wp_head", "CBFA_add_analytics_code");
