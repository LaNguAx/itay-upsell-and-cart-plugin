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
        'iucp_product_add_to_cart_success' => 'Item Added To Cart!'
      );

      update_option('iucp_upsell_manager_options', $defaults);
    }
    if (!get_option('iucp_cart_manager_options')) {
      $defaults = array(
        'iucp_cart_time_zones' => array(
          '09:00' => '12:00',
          '12:00' => '15:00',
          '15:00' => '18:00',
          '18:00' => '21:00',
        )
      );
      update_option('iucp_cart_manager_options', $defaults);
    }
  }
}
