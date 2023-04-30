<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Controllers;

use Inc\Apis\Settings;
use Inc\Controllers\BaseController;
use Inc\Callbacks\TemplatesCallbacks;
use Inc\Callbacks\UpsellCallbacks;

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

      wp_enqueue_script('upsell-slider-js', $this->plugin_url . '/build/slider.js', array(), 1.0, date("h:i:s"), true);
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
      array(
        'option_group' => 'iucp_upsell_manager_settings',
        'option_name' => 'iucp_upsell_manager_categories',
        'callback' => array($this->upsell_callbacks, 'validateProductsData')
      ),
      array(
        'option_group' => 'iucp_upsell_manager_options_group',
        'option_name' => 'iucp_upsell_manager_options',
        'callback' => array($this->upsell_callbacks, 'validateOptionsData')
      )
    );
    $this->settings->setSetting($setting);
  }
  public function setSection() {
    $section = array(
      array(
        'id' => 'iucp_upsell_manager_index',
        'title' => 'Itay Upsell Manager',
        'callback' => array($this->upsell_callbacks, 'sectionProductsManager'),
        'page' => 'itay_upsell_manager'
      ),
      array(
        'id' => 'iucp_upsell_manager_options',
        'title' => 'Upsell Manager Options',
        'callback' => array($this->upsell_callbacks, 'sectionOptionsManager'),
        'page' => 'itay_upsell_manager#tab-3'
      )

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
          'option_name' => 'iucp_upsell_manager_categories',
          'feature_name' => 'iucp_category',
          'category_slug' => $category['slug'],
          'category_name' => $category['name'],
          'term_taxonomy_id' => $category['term_taxonomy_id'],
          'class' => 'ui-toggle',
        ),
      );
    }
    array_push(
      $fields,
      array(
        'id' => 'upsell_heading',
        'title' => 'Upsell Heading',
        'callback' => array($this->upsell_callbacks, 'textOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_heading',
          'placeholder' => 'Enter the heading for your container. <br> Leave empty to have no heading.'
        )
      ),
      array(
        'id' => 'upsell_subheading',
        'title' => 'Upsell Subheading',
        'callback' => array($this->upsell_callbacks, 'textOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_subheading',
          'placeholder' => 'Enter the subheading for your container. <br> Leave empty to have no subheading.'
        )
      ),
      array(
        'id' => 'upsell_category_button_text',
        'title' => 'Category Button Text',
        'callback' => array($this->upsell_callbacks, 'textOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_category_button_text',
          'placeholder' => 'Create concise button category text. <br> Default: View More'
        )
      ),
      array(
        'id' => 'upsell_product_button_text',
        'title' => 'Product Button Text',
        'callback' => array($this->upsell_callbacks, 'textOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_product_button_text',
          'placeholder' => 'Create concise button product text. <br> Default: Add To Cart'
        )
      ),
      array(
        'id' => 'upsell_add_to_cart_success',
        'title' => 'Product Added To Cart Message',
        'callback' => array($this->upsell_callbacks, 'textOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_product_add_to_cart_success',
          'placeholder' => 'Create concise successful add to cart message. <br> Default: Item Added To Cart!'
        )
      ),
      array(
        'id' => 'upsell_category_container_background_color',
        'title' => 'Category Container Background Color',
        'callback' => array($this->upsell_callbacks, 'colorOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_category_container_background_color',
          'placeholder' => 'Choose a background color for the container  ',
          'question' => 'Colored Background? '
        )
      ),
      array(
        'id' => 'upsell_heading_text_color',
        'title' => 'Upsell Heading Text Color',
        'callback' => array($this->upsell_callbacks, 'colorOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_heading_text_color',
          'placeholder' => 'Choose a text color. <br> Default: #FFF - White',
          'question' => 'Colored Heading Text? '
        )
      ),
      array(
        'id' => 'upsell_subheading_text_color',
        'title' => 'Upsell Subheading Text Color',
        'callback' => array($this->upsell_callbacks, 'colorOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_subheading_text_color',
          'placeholder' => 'Choose a text color. <br> Default: #FFF - White',
          'question' => 'Colored Subheading Text? '
        )
      ),
      array(
        'id' => 'upsell_category_button_text_color',
        'title' => 'Category Button Text Color',
        'callback' => array($this->upsell_callbacks, 'colorOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_category_button_text_color',
          'placeholder' => 'Assign a text color: ',
          'question' => 'Choose Category Text Button Color',
          'always_on' => true
        )
      ),
      array(
        'id' => 'upsell_product_button_text_color',
        'title' => 'Product Button Text Color',
        'callback' => array($this->upsell_callbacks, 'colorOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_product_button_text_color',
          'placeholder' => 'Assign a text color: ',
          'question' => 'Choose Product Text Button Color',
          'always_on' => true
        )
      ),
      array(
        'id' => 'upsell_category_button_background_color',
        'title' => 'Category Button Background Color',
        'callback' => array($this->upsell_callbacks, 'colorOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_category_button_background_color',
          'placeholder' => 'Assign a background color: ',
          'question' => 'Choose Category Button Background Color?',
          'always_on' => true
        )
      ),
      array(
        'id' => 'upsell_product_button_background_color',
        'title' => 'Product Button Background Color',
        'callback' => array($this->upsell_callbacks, 'colorOptionsField'),
        'page' => 'itay_upsell_manager#tab-3',
        'section' => 'iucp_upsell_manager_options',
        'args' => array(
          'option_name' => 'iucp_upsell_manager_options',
          'feature_name' => 'iucp_upsell_product_button_background_color',
          'placeholder' => 'Assign a background color: ',
          'question' => 'Choose Product Button Background Color?',
          'always_on' => true
        )
      )
    );
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
