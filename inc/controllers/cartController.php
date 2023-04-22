<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Controllers;

use Inc\Apis\Settings;
use Inc\Controllers\BaseController;
use Inc\Callbacks\DashboardCallbacks;
use Inc\Callbacks\TemplatesCallbacks;

class CartController {

  public array $subpages = array();
  public object $settings;
  public object $templates_callback;

  public function register() {

    if (!BaseController::featureActive('iucp_cart_manager'))
      return;

    $this->settings = new Settings();
    $this->templates_callback = new TemplatesCallbacks();
    $this->addSubPage();

    $this->settings->setSubPages($this->subpages)->register();
  }

  public function addSubPage() {
    $subpages = array(
      array(
        'parent_slug' => 'itay_upsell_and_cart_plugin',
        'page_title' => 'Itay Cart Manager',
        'menu_title' => 'Cart Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_cart_manager',
        'callback' => array($this->templates_callback, 'generateCartPage')
      )
    );
    $this->subpages = $subpages;
  }
}
