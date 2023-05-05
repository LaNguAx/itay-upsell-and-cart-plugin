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

  public function timeZonesOptionsField($args) {
    $option_name = $args['option_name'];
    $feature = $args['feature_name'];
    $description = $args['description'];
    $placeholder = $args['placeholder'];

    $option_value = get_option('iucp_cart_manager_options')['iucp_cart_time_zones'];
?>
    <div id="<?php echo $feature ?>" class="iucp-setting-container text">
      <?php
      foreach ($option_value as $start_time => $time_zone_data) {
        $end_time =  $time_zone_data['end_time'];
      ?>
        <div class="iucp-time-zone-container iucp-flex ">
          <div class="iucp-flex">
            <div class="iucp-flex iucp-flex-col">
              <label for="start-time">Start Time</label>
              <input type="time" min="<?php echo $start_time ?>" max="<?php echo $end_time ?>" id="start-time" class=" iucp-time-zone-input regular-text" name="<?php echo $option_name . '[' . $feature . '][' . $start_time . ']' ?>" value="<?php echo $start_time ?>" placeholder="<?php echo $placeholder ?>">
            </div>
            <div class="iucp-flex iucp-flex-col">
              <label for="end-time">End Time</label>
              <input type="time" min="<?php echo $start_time ?>" max="<?php echo $end_time ?>" id="end-time" class="iucp-time-zone-input regular-text" name="<?php echo $option_name . '[' . $feature . '][' . $start_time . '][end_time]' ?>" value="<?php echo $end_time ?>" placeholder="<?php echo $placeholder ?>">
            </div>
            <div id="iucp_days_of_week" class="iucp-flex">
              <?php
              $days_of_week = array(
                'sunday',
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday'
              );

              $days_selected = isset($option_value[$start_time]['days']) ? $option_value[$start_time]['days'] : false;

              foreach ($days_of_week as $day) {
              ?>
                <div class="iucp-flex iucp-flex-col">
                  <label for="iucp_day_<?php echo $day ?>"><?php echo $day ?></label>

                  <input type="checkbox" name="<?php echo $option_name . '[' . $feature . '][' . $start_time . '][days][' . $day . ']' ?>" id="iucp_day_<?php echo $day ?>" class="iucp_day_of_week" value="1" <?php echo (isset($days_selected[$day]) ? 'checked' : '') ?>>
                </div>
              <?php
              }
              ?>
            </div>
          </div> <label style="display: inline-block; margin-right: 2rem;" for="iucp-time-zone-input"><?php echo $description ?></label>
          <?php submit_button('DELETE', 'delete iucp-flex', 'button', false, array(
            'id' => 'iucp-delete-time-zone-button',
            'style' => 'margin-top: auto;'
          )) ?>
          <br>
        </div>

      <?php
      }
      ?>
    </div>
<?php  }

  // public function textOptionsField($args) {
  // }
  // public function colorsOptionsField($args) {
  // }
}
