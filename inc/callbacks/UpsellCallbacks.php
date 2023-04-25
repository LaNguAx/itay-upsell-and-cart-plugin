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

    $output = get_option('iucp_upsell_manager_categories', array());
    if (isset($_POST['update_products'])) {
      $new_products = array();
      foreach ($_POST['new_products'] as $category => $products) {
        foreach ($products as $id => $product) {
          if (!isset($product['product_name'])) continue;
          $new_products[$category][$id] =
            $product;
        }
      }
      update_option('iucp_upsell_products', $new_products);
      return $output;
    }
    update_option('iucp_upsell_products', array());
    $output = $input_data;
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
      <input type="checkbox" id="<?php echo $option_name . '[' . $category_slug . ']' ?>" value="<?php echo $args['term_taxonomy_id'] ?>" name="<?php echo $option_name . '[' . $category_slug . ']' ?>" <?php echo $checked ?>><label for="<?php echo $option_name . '[' . $category_slug . ']' ?>">
        <div>
        </div>
      </label>
    </div>
<?php
  }
}
