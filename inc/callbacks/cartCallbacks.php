<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Callbacks;

class CartCallbacks {

  public function validateCartSettings($input_data) {
    return $input_data;
  }

  public function cartSectionManager() {
    echo 'hello from cartcallbacks';
  }

  public function textOptionsField($args) {
  }
  public function colorsOptionsField($args) {
  }
}
