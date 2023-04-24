<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Controllers;

use Automattic\WooCommerce\Admin\API\Data;
use Automattic\WooCommerce\Admin\Features\Navigation\Screen;
use Inc\Apis\Settings;
use Inc\Controllers\BaseController;
use Inc\Callbacks\TemplatesCallbacks;
use Inc\Callbacks\UpsellCallbacks;
use WP_Query;

class UpsellController extends BaseController {

  public array $subpages = array();
  public array $product_categories = array();
  public object $settings;
  public object $templates_callback;
  public object $upsell_callbacks;

  public function register() {

    if (!BaseController::featureActive('iucp_upsell_manager'))
      return;



    $this->settings = new Settings();
    $this->templates_callback = new TemplatesCallbacks();
    $this->upsell_callbacks = new UpsellCallbacks();
    $this->addSubPage();


    $this->setSetting();
    $this->setSection();
    add_action('admin_init', array($this, 'getProductCategories'), 9);

    add_action('woocommerce_after_template_part', array($this, 'generateUpsellFrontend'), 10, 1);

    $this->settings->setSubPages($this->subpages)->register();
  }

  public function generateUpsellFrontend($template_name) {
    if (is_product() && $template_name === 'single-product/up-sells.php') {
      require_once($this->plugin_path . '/inc/templates/features/upsell-feature.php');

      wp_enqueue_script('upsell-slider-js', $this->plugin_url . '/build/slider.js', array('jquery'), 1.0, date("h:i:s"), true);
      wp_enqueue_style('user-styles-css', $this->plugin_url . '/build/userstyles.scss.css');
      wp_localize_script('upsell-slider-js', 'storeData', array(
        'siteUrl' => site_url(),
        'nonce' => wp_create_nonce('wc_store_api')
      ));
    }
  }


  public function addSubPage() {
    $subpages = array(
      array(
        'parent_slug' => 'itay_upsell_and_cart_plugin',
        'page_title' => 'Itay Upsell Manager',
        'menu_title' => 'Upsell Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_upsell_manager',
        'callback' => array($this->templates_callback, 'generateUpsellPage')
      )
    );
    $this->subpages = $subpages;
  }

  public function setSetting() {
    $setting = array(
      'option_group' => 'iucp_upsell_manager_settings',
      'option_name' => 'iucp_upsell_manager_setting',
      'callback' => array($this->upsell_callbacks, 'validateData')
    );
    $this->settings->setSetting($setting);
  }
  public function setSection() {
    $section = array(
      'id' => 'iucp_upsell_manager_index',
      'title' => 'Itay Upsell Manager',
      'callback' => array($this->upsell_callbacks, 'sectionManager'),
      'page' => 'itay_upsell_manager'
    );
    $this->settings->setSection($section);
  }
  public function setFields() {
    $fields = array();
    foreach ($this->product_categories as $category) {
      $fields[] = array(
        'id' => $category['term_id'],
        'title' => $category['name'],
        'callback' => array($this->upsell_callbacks, 'checkboxField'),
        'page' => 'itay_upsell_manager',
        'section' => 'iucp_upsell_manager_index',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_setting',
          'feature_name' => 'iucp_category',
          'category_slug' => $category['slug'],
          'category_name' => $category['name'],
          'term_taxonomy_id' => $category['term_taxonomy_id'],
          'class' => 'ui-toggle',
        ),
      );
    }
    $this->settings->setFields($fields);
  }

  public function getProductCategories() {
    $categories = get_terms(array('taxonomy' => 'product_cat'));
    $new_categories = array();
    foreach ($categories as $category) {
      $new_categories[] = array(
        'term_id' => $category->term_id,
        'name' => $category->name,
        'slug' => $category->slug,
        'term_taxonomy_id' => $category->term_taxonomy_id,
        'taxonomy' => $category->taxonomy
      );
    }
    $this->product_categories = $new_categories;
    $this->setFields();
  }
}
