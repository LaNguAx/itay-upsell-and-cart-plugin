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

class dashboardController {

  public object $settings;
  public object $dashboard_callbacks;


  public function register() {
    $this->settings = new Settings();
    $this->dashboard_callbacks = new DashboardCallbacks();

    $this->setSetting();
    $this->setSection();
    $this->setFields();

    $this->settings->register();
  }


  public function setSetting() {
    $setting = array(array(
      'option_group' => 'iucp_dashboard_settings',
      'option_name' => 'iucp_dashboard_setting',
      'callback' => array($this->dashboard_callbacks, 'validateData')
    ));
    $this->settings->setSetting($setting);
  }

  public function setSection() {
    $section = array(array(
      'id' => 'iucp_dashboard_index',
      'title' => 'Itay Upsell & Cart Plugin Settings',
      'callback' => array($this->dashboard_callbacks, 'sectionManager'),
      'page' => 'itay_upsell_and_cart_plugin'
    ));
    $this->settings->setSection($section);
  }
  public function setFields() {
    $fields = array(
      array(
        'id' => 'iucp_upsell_manager',
        'title' => 'Upsell Manager',
        'callback' => array($this->dashboard_callbacks, 'checkboxField'),
        'page' => 'itay_upsell_and_cart_plugin',
        'section' => 'iucp_dashboard_index',
        'args' => array(
          'option_name' => 'iucp_dashboard_setting',
          'feature_name' => 'iucp_upsell_manager',
          'class' => 'ui-toggle',
        ),
      ),
      array(
        'id' => 'iucp_cart_manager',
        'title' => 'Cart Manager',
        'callback' => array($this->dashboard_callbacks, 'checkboxField'),
        'page' => 'itay_upsell_and_cart_plugin',
        'section' => 'iucp_dashboard_index',
        'args' => array(
          'option_name' => 'iucp_dashboard_setting',
          'feature_name' => 'iucp_cart_manager',
          'class' => 'ui-toggle',
        ),
      )
    );
    $this->settings->setFields($fields);
  }
}
