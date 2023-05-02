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
use WC_DateTime;
use WC_Shipping_Zones;

use function PHPSTORM_META\type;

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

    add_filter('woocommerce_states', array($this, 'custom_woocommerce_states'));
    add_filter('woocommerce_checkout_fields', array($this, 'updateShippingFields'));

    add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
    add_action('wp_ajax_iucp_create_date_time', array($this, 'handleAjax'));
    add_action('wp_ajax_nopriv_iucp_create_date_time', array($this, 'handleAjax'));
    if (!isset($_COOKIE['iucp_session_address']))
      add_action('iucp_initialize_address', array($this, 'loadCartAddress'));

    $this->settings->setSubPages($this->subpages)->register();
  }

  public function updateShippingFields($fields) {
    // if (!isset($_COOKIE['iucp_session_address']))
    // return $fields;

    // Continue from here.

    $fields['shipping']['shipping_phone'] = array(
      'type' => 'select',
      'label' => 'Delivery Time',
      'required' => true,
      'placeholder' => 'Delivery Time',
      'options' => array(
        'option_1' => 'helo',
        'options_2' => 'hello2'
      ),
      'class'     => array('form-row-wide'),
    );

    return $fields;
  }

  function custom_woocommerce_states($states) {

    $states['IL'] = array(
      'IL1' => 'רחובות',
      'IL2' => 'קריית עקרון',
      'IL3' => 'נס ציונה',
      'IL4' => 'ראשון לציון',
      'IL5' => 'יבנה',
      'IL6' => 'באר יעקב'
    );

    return $states;
  }


  public function handleAjax() {
    check_ajax_referer('iucp_time', 'iucp_date_time');
    if (isset($_COOKIE['iucp_session_address'])) {
      echo json_encode(array(
        'error' => 'invalid request, user already has cookies'
      ));
      die();
    }
    $session_address = array(
      'arrival_date' => $_POST['iucp_address_arrival_date'],
      'arrival_time' => $_POST['iucp_address_arrival_time'],
      'arrival_location' => $_POST['iucp_address_location'],
    );
    // echo json_encode($session_address);

    // To load the cookie !
    // setcookie('iucp_session_address', json_encode($session_address), time() + 7200, COOKIEPATH, COOKIE_DOMAIN);

    // setcookie('iucp_session_address', , time() + 62208000, '/', $_SERVER['HTTP_HOST']);
    echo json_encode($_COOKIE);

    die();
  }

  public function load_scripts() {
    wp_enqueue_script('cart-js', $this->plugin_url . '/build/cart.js', array('jquery', 'jquery-ui-datepicker'), 1.0, true);
    wp_register_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('jquery-ui');
    wp_enqueue_style('user-styles-css', $this->plugin_url . '/build/userstyles.scss.css');

    wp_localize_script('cart-js', 'iucpTimes', array(
      '01:00' => '12:00',
      '02:00' => '15:00',
      '15:00' => '18:00',
      '18:00' => '21:00',
    ));
  }

  public function loadCartAddress() {
    $shipping_zones = WC_Shipping_Zones::get_zones();

?>
    <div class="iucp-address-container">
      <form autocomplete="off" id="iucp_form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
        <label for="iucp_address_location"><?php echo __('Location', 'woocommerce') ?></label>
        <input required list="iucp_address_locations" id="hoepkao" name="iucp_address_location">
        <datalist id="iucp_address_locations">
          <?php
          foreach ($shipping_zones as $zone) {
            echo '<option>' . $zone['zone_name'] . '</option>';
          }
          ?>
        </datalist>
        <label for="iucp_address_date"><?php echo __('Date', 'woocommerce') ?></label>
        <input required id="iucp_datepicker" type="text" name="iucp_address_arrival_date">
        <label id="arrival-time-label" class="hidden" for="iucp_address_arrival_time"><?php echo __('Delivery', 'woocommerce') ?></label>
        <?php $current_time = strtotime(wp_date('H:i')); ?>
        <select id="iucp_address_arrival_time" name="iucp_address_arrival_time" class="hidden">
          <!-- <?php $times = array(
                  '01:00' => '12:00',
                  '02:00' => '15:00',
                  '15:00' => '18:00',
                  '18:00' => '21:00',
                );
                foreach ($times as $start_time => $end_time) {
                  $str_start_time = strtotime($start_time);
                  if ($current_time - 3600 < $str_start_time) {
                ?>
              <option value="<?php echo $start_time . '-' . $end_time ?>"><?php echo $start_time . '-' . $end_time ?></option>
          <?php }
                }
          ?> -->
        </select>

        <input type="hidden" name="action" value="iucp_create_date_time">
        <?php wp_nonce_field('iucp_time', 'iucp_date_time'); ?>

        <input id="iucp_submit_address_button" type="submit" name="iucp_submit_address_button" value="1">
        <label id="iucp-label-submit" for="iucp_submit_address_button"><?php echo __('Add To Cart', 'woocommerce') ?></label>
      </form>
    </div>

<?php
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
