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
  public array $sections = array();
  public array $fields = array();

  public function register() {

    if (!empty($this->admin_pages) || !empty($this->admin_subpages)) {
      add_action('admin_menu', array($this, 'generateMenus'));
    }

    if (!empty($this->settings)) {
      add_action('admin_init', array($this, 'generateSettings'), 10);
    }
  }

  public function setSetting(array $setting) {
    $this->settings = $setting;
    return $this;
  }

  public function setSection(array $section) {
    $this->sections = $section;
    return $this;
  }

  public function setFields(array $fields) {
    $this->fields = $fields;
    return $this;
  }

  public function generateSettings() {
    foreach ($this->settings as $setting) {
      register_setting($setting['option_group'], $setting['option_name'], isset($setting['callback']) ? $setting['callback'] : null);
    }
    foreach ($this->sections as $section) {
      add_settings_section($section['id'], $section['title'], isset($section['callback']) ? $section['callback'] : null, $section['page']);
    }
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
