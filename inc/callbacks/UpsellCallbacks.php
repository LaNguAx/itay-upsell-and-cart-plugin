<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Callbacks;

use Inc\Controllers\BaseController;

class UpsellCallbacks {

  public function validateProductsData($input_data) {

    $output = get_option('iucp_upsell_manager_categories', array());
    if (isset($_POST['update_products'])) {
      $new_products = array();
      foreach ($_POST['new_products'] as $category => $products) {
        foreach ($products as $id => $product) {
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

  public function sectionProductsManager() {
    $categories_exist = get_option('iucp_upsell_manager_categories');
?>
    <div>
      <p>In this settings page you can activate or deactivate this plugin's features as you wish.</p>
      <?php if (!$categories_exist)  ?>
      <p class="<?php echo (!$categories_exist ? '' : 'hidden') ?>">Select categories to begin further customizing your upsell feature.</p>
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



  // Upsell Options
  public function validateOptionsData($input_data) {
    $output = array();
    $defaults = array(
      'iucp_category_button_text' => 'View More',
      'iucp_product_button_text' => 'Add To Cart',
      'iucp_upsell_category_button_background_color' => '#add8e6',
      'iucp_upsell_product_button_background_color' => '#add8e6',
      'iucp_upsell_category_button_text_color' => '#ffffff',
      'iucp_upsell_product_button_text_color' => '#ffffff',
      'iucp_upsell_slider_items_per_view' => 3
    );
    if ($_POST['submit'] === 'Reset') {
      return $defaults;
    }

    foreach ($input_data as $key => $value) {
      if (isset($defaults[$key])) {
        $output[$key] = $value ? $value : $defaults[$key];
      } else {
        $output[$key] = $value;
      }
    }
    return $output;
  }

  public function sectionOptionsManager() {
    echo '
    <p class="tab-subheading">Customize the look of your upsell products container!</p>';
  }
  public function textOptionsField($args) {
    $option_name = $args['option_name'];
    $feature_name = $args['feature_name'];
    $placeholder = $args['placeholder'];
    $option_data = get_option($option_name);
    $value = isset($option_data[$feature_name]) ? $option_data[$feature_name] : '';

  ?>
    <div class="iucp-setting-container text">
      <input type="text" class="regular-text" name="<?php echo $option_name . '[' . $feature_name . ']' ?>" value="<?php echo $value ?>">
      <p><?php echo $placeholder ?></p>
    </div>

  <?php
  }
  public function colorOptionsField($args) {
    $option_name = $args['option_name'];
    $feature_name = $args['feature_name'];
    $placeholder = $args['placeholder'];
    $always_on = isset($args['always_on']);
    $option_data = get_option($option_name);
    $value = isset($option_data[$feature_name]) ? $option_data[$feature_name] : '';

  ?>
    <div class="iucp-setting-container color">
      <div class="toggle-background">
        <label for="<?php echo $feature_name ?>"><?php echo $args['question'] ?></label>
        <input id="<?php echo $feature_name ?>" class="color-checkbox <?php echo $always_on ? 'always-on' : '' ?>" type="checkbox" value="1" <?php echo ($value || $always_on ? 'checked' : '') ?>>
        <br>
        <?php if (!$always_on) {
        ?>
          <p>Leave unchecked for default.</p>
        <?php
        } ?>
      </div>
      <div class="color-picker-container <?php echo ($value || $always_on ? '' : 'hidden') ?>">
        <input type="<?php echo ($value || $always_on ? 'color' : 'checkbox') ?>" name="<?php echo $option_name . '[' . $feature_name . ']' ?>" value="<?php echo $value ?>">
        <p><?php echo $placeholder ?></p>
      </div>
    </div>

  <?php

  }

  public function numberOptionsField($args) {
    $option_name = $args['option_name'];
    $feature_name = $args['feature_name'];
    $placeholder = $args['placeholder'];
  ?>
    <div class="iucp-setting-container">
      <input type="number" name="<?php echo $option_name . '[' . $feature_name . ']' ?>" id="<?php echo $feature_name ?>" min="3" value="<?php echo get_option($option_name)[$feature_name] ?>">
      <p><?php echo $placeholder  ?></p>
    </div>
<?php
  }
}
