<div class="wrap upsell-manager">
  <h1></h1>
  <?php settings_errors();
  $categories_exist = get_option('iucp_upsell_manager_setting');
  ?>

  <ul class="nav nav-tabs">
    <li class="<?php echo (!$categories_exist ? 'active' : '') ?>"><a href="#tab-1">Choose Categories</a></li>
    <li class="<?php echo ($categories_exist ? 'active' : 'hidden') ?>"><a href="#tab-2">Select Products</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo (!$categories_exist ? 'active' : '') ?>">
      <form method="post" action="options.php">
        <?php
        settings_fields('iucp_upsell_manager_settings');
        do_settings_sections('itay_upsell_manager');
        submit_button();
        ?>
      </form>
    </div>
    <div id="tab-2" class="tab-pane <?php echo ($categories_exist ? 'active' : 'hidden') ?>">
      <h3>Select Products</h3>
      <p>Select the products you'd like to showcase in the slideshow in the product page!</p>

      <div class="wrap">
        <form action="options.php" method="post">
          <?php
          foreach ($categories_exist as $key => $val) {
          ?>
            <h3 class="categories-selected"><?php echo strtoupper($key[0]) . substr($key, 1) ?></h3>

            <?php
            foreach ($val as $product) {
            ?>
              <?php echo $product['product_image'] ?>
              <span><?php echo $product['product_name'] ?></span>
              <input type="checkbox" value="1" name="<?php echo $key . '[' . $product['product_name'] . ']' ?>">

          <?php
            }
          }
          settings_fields('iucp_upsell_manager_settings');
          submit_button('Update Products', 'primary', 'submit', false);

          ?>
          <input type="hidden" name="update_products" value="1">
        </form>
      </div>

    </div>
  </div>


</div>