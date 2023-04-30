<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Controllers;

use Inc\Apis\Settings;
use Inc\Callbacks\CartCallbacks;
use Inc\Controllers\BaseController;
use Inc\Callbacks\TemplatesCallbacks;

class CartController extends BaseController {

  public array $subpages = array();
  public object $settings;
  public object $templates_callback;
  public object $cart_callbacks;

  public function register() {

    if (!BaseController::featureActive('iucp_cart_manager'))
      return;

    $this->settings = new Settings();
    $this->templates_callback = new TemplatesCallbacks();
    $this->cart_callbacks = new CartCallbacks();
    $this->addSubPage();

    $this->setSettings();
    $this->setSections();
    $this->setFields();

    add_action('wp', array($this, 'generateCartFrontend'));
    $this->settings->setSubPages($this->subpages)->register();
  }


  public function generateCartFrontend() {
    if (!is_admin()) {
      require_once($this->plugin_path . '/inc/templates/features/cart-feature.php');
      wp_enqueue_script('cart-js', $this->plugin_url . '/build/cart.js', array(), 1.0, date("h:i:s"), true);
      wp_enqueue_style('user-styles-css', $this->plugin_url . 'build/userstyles.scss.css');
      wp_localize_script('cart-js', 'storeData', array(
        'siteUrl' => site_url(),
        'nonce' => wp_create_nonce('wc_store_api')
      ));
    }
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

  public function setSettings() {
    $setting = array(
      array(
        'option_group' => 'iucp_cart_manager_settings',
        'option_name' => 'iucp_cart_manager_options',
        'callback' => array($this->cart_callbacks, 'validateCartSettings')
      ),
    );
    $this->settings->setSetting($setting);
  }
  public function setSections() {
    $section = array(
      array(
        'id' => 'iucp_cart_manager_index',
        'title' => 'Itay Cart Manager',
        'callback' => array($this->cart_callbacks, 'cartSectionManager'),
        'page' => 'itay_cart_manager'
      ),
    );
    $this->settings->setSection($section);
  }
  public function setFields() {
    $fields = array(
      array(
        'id' => 'iucp_cart_header',
        'title' => 'Cart Header',
        'callback' => array($this->cart_callbacks, 'textOptionsField'),
        'page' => 'itay_cart_manager',
        'section' => 'iucp_cart_manager_index',
        'args' => array(
          'option_name' => 'iucp_cart_manager_options',
          'feature_name' => 'iucp_cart_header',
        ),
      )
    );
    $this->settings->setFields($fields);
  }
}
