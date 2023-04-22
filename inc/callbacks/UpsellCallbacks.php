<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Callbacks;

use Inc\Controllers\BaseController;

class UpsellCallbacks {

  public function validateData($input_data) {

    $output = array();
    foreach ($input_data as $key => $value) {
      $products_from_cat =  wc_get_products(
        array(
          'category' => $key
        )
      );
      $products = array();
      foreach ($products_from_cat as $product) {
        $products[] = array(
          'product_id' => $product->get_id(),
          'product_name' => $product->get_name(),
          'product_price' => $product->get_price(),
          'product_image' => $product->get_image(),
        );
      }
      $output[$key] = $products;
    }
    return $output;
  }
  public function sectionManager() {
?>
    <div>
      <p>In this settings page you can activate or deactivate this plugin's features as you wish.</p>
    </div>
  <?php
  }
  public function checkboxField($args) {
    $option_name = $args['option_name'];
    $category_name = $args['category_name'];
    $category_slug = $args['category_slug'];
    $option_data = get_option($option_name);
    $checked = isset($option_data[$category_slug]) ? 'checked' : '';


  ?>
    <div class="<?php echo $args['class'] ?>">
      <input type="checkbox" id="<?php echo $option_name . '[' . $category_slug . ']' ?>" value="1" name="<?php echo $option_name . '[' . $category_slug . ']' ?>" <?php echo $checked ?>><label for="<?php echo $option_name . '[' . $category_slug . ']' ?>">
        <div>
        </div>
      </label>
    </div>
<?php
  }
}
