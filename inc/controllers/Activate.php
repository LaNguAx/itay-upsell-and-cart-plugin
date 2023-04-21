<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Controllers;

class Activate {

  public static function activate() {
    flush_rewrite_rules();
    $defaults = array();
  }
}
