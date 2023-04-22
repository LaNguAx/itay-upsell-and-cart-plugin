<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Controllers;

class Activate {

  public static function activate() {
    flush_rewrite_rules();
    $defaults = array();
    if (!get_option('iucp_dashboard_setting')) {
      update_option('iucp_dashboard_setting', $defaults);
    }
    if (!get_option('iucp_upsell_manager_setting')) {
      update_option('iucp_upsell_manager_setting', $defaults);
    }
    if (!get_option('iucp_upsell_products')) {
      update_option('iucp_upsell_products', $defaults);
    }
  }
}
