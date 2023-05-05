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

    $this->initiateHooks();

    $this->settings->setSubPages($this->subpages)->register();
  }

  public function initiateHooks() {
    // seperate module
    // add_filter('woocommerce_states', array($this, 'custom_woocommerce_states'));
    // add_filter('woocommerce_checkout_fields', array($this, 'updateShippingFields'));

    add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

    add_action('wp_ajax_iucp_create_date_time', array($this, 'handleAjax'));

    add_action('wp_ajax_nopriv_iucp_create_date_time', array($this, 'handleAjax'));

    if (!isset($_COOKIE['iucp_session_address']))
      add_action('iucp_initialize_address', array($this, 'loadCartAddress'));

    add_filter('xoo_side-cart-woocommerce_template_located', array($this, 'replaceTemplate'), 10, 2);
  }

  public function replaceTemplate($template, $template_name) {

    if ($template_name == 'xoo-wsc-container.php') {
      $template =  $this->plugin_path . 'inc/templates/overrides/override.php';

      return $template;
    }
    return $template;
  }

  // Move this to a seperate module.
  // public function updateShippingFields($fields) {
  //   if (!isset($_COOKIE['iucp_session_address']))
  //     return $fields;

  //   $iucp_data = json_decode(stripslashes($_COOKIE['iucp_session_address']), true);


  //   $fields['shipping']['delivery_time'] = array(
  //     'type' => 'select',
  //     'label' => 'Delivery Time',
  //     'required' => true,
  //     'placeholder' => 'Delivery Time',
  //     'options' => array(
  //       'option_1' => $iucp_data['arrival_time'],
  //     ),
  //     'class'     => array('form-row-wide', 'update_totals_on_change'),
  //   );
  //   $fields['shipping']['location'] = array(
  //     'type' => 'text',
  //     'label' => 'Location',
  //     'required' => true,
  //     'placeholder' => 'Location',
  //     'default' => $iucp_data['arrival_location'],
  //     'class'     => array('form-row-wide', 'update_totals_on_change'),
  //   );
  //   $fields['shipping']['arrival_date'] = array(
  //     'type' => 'text',
  //     'label' => 'Arrival Date',
  //     'readonly' => true,
  //     'placeholder' => 'Arrival Date',
  //     'default' => $iucp_data['arrival_date'],
  //     'custom_attributes' => array(
  //       'readonly' => 'readonly'
  //     ),
  //     'class'     => array('form-row-wide', 'update_totals_on_change'),
  //   );

  //   // continue here updating the fields 
  //   $fields['shipping']['shipping_state']['class'][] = 'update_totals_on_change';
  //   return $fields;
  // }

  // function custom_woocommerce_states($states) {

  //   $states['IL'] = array(
  //     'IL1' => 'רחובות',
  //     'IL2' => 'קריית עקרון',
  //     'IL3' => 'נס ציונה',
  //     'IL4' => 'ראשון לציון',
  //     'IL5' => 'יבנה',
  //     'IL6' => 'באר יעקב'
  //   );

  //   return $states;
  // }


  public function handleAjax() {
    check_ajax_referer('iucp_time', 'iucp_date_time');
    header('Content-Type: application/json');

    if (isset($_COOKIE['iucp_session_address'])) {
      echo json_encode(array(
        'error' => 'Dont get smart with me'
      ));
      die();
    }

    $session_address = array(
      'arrival_date' => $_POST['iucp_address_arrival_date'],
      'arrival_time' => $_POST['iucp_address_arrival_time'],
      'arrival_location' => $_POST['iucp_address_location'],

    );

    // Loading a cookie on the user
    setcookie('iucp_session_address', json_encode($session_address), time() + 7200, COOKIEPATH, COOKIE_DOMAIN);
    echo json_encode($session_address['arrival_date']);
    die();
  }

  public function load_scripts() {
    wp_enqueue_script('cart-js', $this->plugin_url . '/build/cart.js', array('jquery', 'jquery-ui-datepicker'), 1.0, true);
    wp_register_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('jquery-ui');
    wp_enqueue_style('user-styles-css', $this->plugin_url . '/build/userstyles.scss.css');


    $time_zones = get_option('iucp_cart_manager_options')['iucp_cart_time_zones'];
    wp_localize_script('cart-js', 'iucpTimes', $time_zones);
  }

  public function loadCartAddress() {
    require_once $this->plugin_path  . '/inc/templates/features/cart-feature.php';
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
        'id' => 'iucp_cart_time_zones',
        'title' => 'Time Zones',
        'callback' => array($this->cart_callbacks, 'timeZonesOptionsField'),
        'page' => 'itay_cart_manager',
        'section' => 'iucp_cart_manager_index',
        'args' => array(
          'option_name' => 'iucp_cart_manager_options',
          'feature_name' => 'iucp_cart_time_zones',
          'placeholder' => 'hh:mm',
          'description' => "hh:mm -> example: <strong>14:22</strong>"
        ),
      )
    );
    $this->settings->setFields($fields);
  }
}
