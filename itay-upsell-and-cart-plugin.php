<?php

/**
 * @package ItayUpsellAndCartPlugin
 */


/*
Plugin Name: Itay Upsell & Cart Plugin
Plugin URI: https://github.com/LaNguAx/itay-upsell-and-cart-plugin
Description: Itay's Upsell & Cart Time Zones is a Wordpress Plugin and a WooCommerce & Side Cart Woocommerce's extension that allows online store owners to increase sales by displaying related products through the Upsell feature and providing a convenient way for customers to input location and arrival time through the Cart Time Zones feature.
Version: 1.0.0
Author: Itay Andre Aknin
Author URI: https://www.linkedin.com/in/itay-aknin-aa5691270/
License: GPLv2
Text Domain: itay-upsell-and-cart-plugin
*/

defined('ABSPATH') or die('Hey, you can\t access this file, you silly human!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function activate_itay_plugin() {
  Inc\Controllers\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_itay_plugin');

function deactivate_itay_plugin() {
  Inc\Controllers\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_itay_plugin');

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('woocommerce/woocommerce.php')) {
  function initialize_IUCP() {
    if (class_exists('Inc\\Init')) {
      Inc\Init::register_services();
    }
  }
  add_action('woocommerce_init', 'initialize_IUCP', 10);
} else {
  function deactivateThePlugin() {
    deactivate_plugins('/itay-upsell-and-cart-plugin/itay-upsell-and-cart-plugin.php');
  }
  add_action('admin_init', 'deactivateThePlugin');

  function activationFailedMessage() {
    global $pagenow;
    if ($pagenow === 'plugins.php') {
?>
      <div class="notice notice-error is-dismissible">
        <p><?php _e('Error: Itay Upsell & Cart Plugin failed to activate. Please check you have Woocommerce activated before activating the plugin!', 'sample-text-domain'); ?></p>
      </div>

<?php }
  }
  add_action('admin_notices', 'activationFailedMessage');
}
