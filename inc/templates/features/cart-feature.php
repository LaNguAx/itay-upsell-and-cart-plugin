<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */
?>

<div class="iucp-address-container">
  <form autocomplete="off" id="iucp_form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
    <label for="iucp_address_location"><?php echo __('Location', 'woocommerce') ?></label>
    <input required list="iucp_address_locations" id="hoepkao" name="iucp_address_location">
    <datalist id="iucp_address_locations"></datalist>
    <label for="iucp_address_date"><?php echo __('Date', 'woocommerce') ?></label>
    <input required id="iucp_datepicker" type="text" name="iucp_address_arrival_date">
    <label id="arrival-time-label" class="hidden" for="iucp_address_arrival_time"><?php echo __('Delivery', 'woocommerce') ?></label>
    <?php $current_time = strtotime(wp_date('H:i')); ?>
    <select id="iucp_address_arrival_time" name="iucp_address_arrival_time" class="hidden"> </select>
    <input type="hidden" name="action" value="iucp_create_date_time">
    <?php wp_nonce_field('iucp_time', 'iucp_date_time'); ?>

    <input id="iucp_submit_address_button" type="submit" name="iucp_submit_address_button" value="1">
    <label id="iucp-label-submit" for="iucp_submit_address_button"><?php echo __('Add To Cart', 'woocommerce') ?></label>
  </form>
</div>