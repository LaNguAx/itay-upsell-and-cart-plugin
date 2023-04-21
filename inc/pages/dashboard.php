<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Pages;

use Inc\Apis\Settings;
use Inc\Callbacks\DashboardCallbacks;

class Dashboard {

  public array $page = array();
  public array $subpages = array();
  public array $default_subpage = array();
  public object $dashboard_callbacks;
  public object $settings_api;

  public  function register() {
    $this->dashboard_callbacks = new DashboardCallbacks();
    $this->settings_api = new Settings();

    $this->setPage();
    $this->setSubPages();

    $this->settings_api->setPages($this->page)->withSubPage($this->default_subpage)->setSubPages($this->subpages)->register();
  }

  public function setPage() {
    $this->page = array(
      array(
        'page_title' => 'Itay Upsell & Cart Plugin',
        'menu_title' => 'Itay Upsell & Cart',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_upsell_and_cart_plugin',
        'callback' => array($this->dashboard_callbacks, 'generateDashboardPage'),
        'icon_url' => 'dashicons-smiley',
        'position' => 100,
      )
    );
  }

  public function defaultSubPage(string $title = 'Dashboard') {
    $default_subpage = array(
      array(
        'parent_slug' => 'itay_upsell_and_cart_plugin',
        'page_title' => 'Itay Upsell & Cart Plugin',
        'menu_title' => $title,
        'capability' => 'manage_options',
        'menu_slug' => 'itay_upsell_and_cart_plugin',
        'callback' => array($this->dashboard_callbacks, 'generateDashboardPage')
      )
    );
    $this->default_subpage = $default_subpage;
  }

  public function setSubPages() {
    $subpages = array(
      array(
        'parent_slug' => 'itay_upsell_and_cart_plugin',
        'page_title' => 'Itay Upsell Manager',
        'menu_title' => 'Upsell Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_upsell_manager',
        'callback' => array($this->dashboard_callbacks, 'generateUpsellPage')
      )
    );

    $this->subpages = $subpages;
  }
}
