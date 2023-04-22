<?php

/**
 *
 * @package ItayUpsellAndCartPlugin
 *
 */

namespace Inc\Callbacks;

use Inc\Controllers\BaseController;

class TemplatesCallbacks extends BaseController {
  public function generateDashboardPage() {
    wp_enqueue_script('dashboard-js', $this->plugin_url . 'build/dashboard.js', array(), 1.0, true);
    wp_enqueue_style('admin-css', $this->plugin_url . 'build/adminstyles.scss.css', 1.0);
    return require_once($this->plugin_path . 'inc/templates/pages/dashboard.php');
  }
  public function generateUpsellPage() {
    wp_enqueue_script('upsell-manager-js', $this->plugin_url . 'build/upsell-manager.js', array(), 1.0, true);
    wp_enqueue_style('admin-css', $this->plugin_url . 'build/adminstyles.scss.css', 1.0);
    return require_once($this->plugin_path . 'inc/templates/subpages/upsell-manager.php');
  }

  public function generateCartPage() {
    wp_enqueue_style('admin-css', $this->plugin_url . 'build/adminstyles.scss.css', 1.0);
    return require_once($this->plugin_path . 'inc/templates/subpages/cart-manager.php');
  }
}
