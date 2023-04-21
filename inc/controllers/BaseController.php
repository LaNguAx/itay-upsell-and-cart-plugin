<?php

/**
 * @package ItayUpsellAndCartPlugin
 */

namespace Inc\Controllers;

class BaseController {
  public string $plugin_path;
  public string $plugin_url;
  public string $plugin_name;

  public function __construct() {
    // Specifiy the level of indentation of our file.
    $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
    $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
    $this->plugin_name = plugin_basename(dirname(__FILE__, 3)) . '/itay-upsell-and-cart-plugin.php';
  }
}
