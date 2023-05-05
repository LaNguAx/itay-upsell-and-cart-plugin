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
    if (!get_option('iucp_upsell_manager_categories')) {
      update_option('iucp_upsell_manager_categories', $defaults);
    }
    if (!get_option('iucp_upsell_products')) {
      update_option('iucp_upsell_products', $defaults);
    }
    if (!get_option('iucp_upsell_manager_options')) {
      $defaults = array(
        'iucp_category_button_text' => 'View More',
        'iucp_product_button_text' => 'Add To Cart',
        'iucp_upsell_category_button_background_color' => '#add8e6',
        'iucp_upsell_product_button_background_color' => '#add8e6',
        'iucp_upsell_category_button_text_color' => '#ffffff',
        'iucp_upsell_product_button_text_color' => '#ffffff',
        'iucp_upsell_slider_items_per_view' => 3
      );

      update_option('iucp_upsell_manager_options', $defaults);
    }
    if (!get_option('iucp_cart_manager_options')) {
      $defaults = array(
        'iucp_cart_time_zones' => array(
          '09:00' => array('end_time' => '12:00', 'days' => array()),
          '12:00' => array('end_time' => '15:00', 'days' => array()),
          '15:00' => array('end_time' => '18:00', 'days' => array()),
          '18:00' => array('end_time' => '21:00', 'days' => array()),
        )
      );
      update_option('iucp_cart_manager_options', $defaults);
    }
  }
}
