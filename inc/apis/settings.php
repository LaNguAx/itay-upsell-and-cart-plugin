<?php

/**
 *
 * @package ItayUpsellAndCartPlugin
 *
 */

namespace Inc\Apis;

class Settings {

  public array $admin_pages = array();
  public array $admin_subpages = array();

  public array $settings = array();
  public array $section = array();
  public array $fields = array();

  public function register() {

    if (!empty($this->admin_pages) || !empty($this->admin_subpages)) {
      add_action('admin_menu', array($this, 'generateMenus'));
    }

    if (!empty($this->settings)) {
      add_action('admin_init', array($this, 'generateSettings'), 10);
    }
  }

  public function setSetting($setting) {
    $this->settings = $setting;
    return $this;
  }

  public function setSection($section) {
    $this->section = $section;
    return $this;
  }

  public function setFields($fields) {
    $this->fields = $fields;
    return $this;
  }

  public function generateSettings() {
    register_setting($this->settings['option_group'], $this->settings['option_name'], isset($this->settings['callback']) ? $this->settings['callback'] : null);

    add_settings_section($this->section['id'], $this->section['title'], isset($this->section['callback']) ? $this->section['callback'] : null, $this->section['page']);

    foreach ($this->fields as $field) {
      add_settings_field($field['id'], $field['title'], isset($field['callback']) ? $field['callback'] : null, $field['page'], $field['section'], isset($field['args']) ? $field['args'] : null);
    }
  }



  public function setPages(array $pages) {
    $this->admin_pages = $pages;
    return $this;
  }
  public function withSubPage(array $page) {
    $this->admin_subpages = $page;
    return $this;
  }

  public function setSubPages(array $subpages) {
    $this->admin_subpages = array_merge($this->admin_subpages, $subpages);
    return $this;
  }

  public function generateMenus() {
    foreach ($this->admin_pages as $admin_page) {
      add_menu_page($admin_page['page_title'], $admin_page['menu_title'], $admin_page['capability'], $admin_page['menu_slug'], $admin_page['callback'], $admin_page['icon_url'], $admin_page['position']);
    }

    foreach ($this->admin_subpages as $admin_subpage) {
      add_submenu_page($admin_subpage['parent_slug'], $admin_subpage['page_title'], $admin_subpage['menu_title'], $admin_subpage['capability'], $admin_subpage['menu_slug'], $admin_subpage['callback']);
    }
  }
}
