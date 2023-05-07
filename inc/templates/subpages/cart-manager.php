<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */
?>

<div class="wrap cart-manager">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1">Cart Manager</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane active">
      <form method="post" action="options.php">
        <?php
        settings_fields('iucp_cart_manager_settings');
        do_settings_sections('itay_cart_manager');
        ?>
        <div class="iucp-flex">
          <?php
          submit_button();
          submit_button('Add Timezone', 'delete', 'button', 'true', array(
            'id' => 'iucp-add-time-zone-button'
          ));
          ?>
        </div>
      </form>
    </div>
  </div>
</div>