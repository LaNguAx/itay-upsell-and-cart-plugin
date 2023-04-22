<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */

namespace Inc\Callbacks;

use Inc\Controllers\BaseController;

class DashboardCallbacks {

  public function validateData($input_data) {
    $output = array();
    foreach ($input_data as $key => $value) {
      $output[$key] = isset($key) ? true : false;
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
    $feature_name = $args['feature_name'];

    $option_data = get_option($option_name);
    $checked = isset($option_data[$feature_name]) ? 'checked' : '';
  ?>
    <div class="<?php echo $args['class'] ?>">
      <input type="checkbox" id="<?php echo $feature_name ?>" value="1" name="<?php echo $option_name . '[' . $feature_name . ']' ?>" <?php echo $checked ?>><label for="<?php echo $feature_name ?>">
        <div></div>
      </label>
    </div>
<?php
  }
}
