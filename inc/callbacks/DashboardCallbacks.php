<?php

/**
 *
 * @package ItayUpsellAndCartPlugin
 *
 */

namespace Inc\Callbacks;

use Inc\Controllers\BaseController;

class DashboardCallbacks extends BaseController {
  public function generateDashboardPage() {
    wp_enqueue_script('dashboard-js', $this->plugin_url . 'build/dashboard.js', array(), 1.0, true);
    wp_enqueue_style('admin-css', $this->plugin_url . 'build/adminstyles.css', 1.0);
    return require_once($this->plugin_path . 'inc/templates/pages/dashboard.php');
  }
  public function generateUpsellPage() {
  }
}
