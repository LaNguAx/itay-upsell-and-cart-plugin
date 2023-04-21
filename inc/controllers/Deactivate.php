<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Controllers;

class Deactivate {

  public static function deactivate() {
    flush_rewrite_rules();
  }
}
