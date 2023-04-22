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
  }
}
