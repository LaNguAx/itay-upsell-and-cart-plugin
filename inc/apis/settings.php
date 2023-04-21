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

  public function register() {

    if (!empty($this->admin_pages) || !empty($this->admin_subpages)) {
      add_action('admin_menu', array($this, 'generateMenus'));
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
