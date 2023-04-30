<div class="wrap cart-manager">
  <?php settings_errors();
  ?>

  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1">Cart Manager</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane active">
      <form method="post" action="options.php">
        <?php
        settings_fields('iucp_cart_manager_settings');
        do_settings_sections('itay_cart_manager');
        submit_button();
        ?>
      </form>
    </div>
  </div>
</div>