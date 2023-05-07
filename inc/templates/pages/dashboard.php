<?php

/**
 * 
 * @package ItayUpsellAndCartPlugin
 *  
 */
?>

<div class="wrap">
  <h1></h1>
  <?php settings_errors(); ?>




  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1">Manage Settings</a></li>
    <li><a href="#tab-2">About</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane active">
      <form method="post" action="options.php">
        <?php
        settings_fields('iucp_dashboard_settings');
        do_settings_sections('itay_upsell_and_cart_plugin');
        submit_button();
        ?>
      </form>

    </div>
    <div id="tab-2" class="tab-pane">
      <h3>About</h3>
      <h4>Itay Andre Aknin</h4>
      <a style="font-size: 1.3rem;" href="https://www.instagram.com/itay_aknin">@instagram</a>
      <br>
      <br>
      <a style="font-size: 1.3rem;" href="https://github.com/LaNguAx">@github</a>
      <br>
      <br>
      <a style="font-size: 1.3rem;" href="https://www.linkedin.com/in/itay-aknin-aa5691270/">@linkedin</a>
      <br>
      <br>
      <p style="font-size: 1.1rem;">
        tyvm to: <a href="https://www.linkedin.com/in/alecaddd/">@alessandro_castellani</a>
      </p>
    </div>
  </div>


</div>