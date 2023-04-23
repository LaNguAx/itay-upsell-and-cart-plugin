<div class="wrap upsell-manager">
  <h1></h1>
  <?php settings_errors();
  $categories_exist = get_option('iucp_upsell_manager_setting');
  $products_selected = get_option('iucp_upsell_products');
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
      <h3 class="tab-heading">Select Products</h3>
      <p class="tab-subheading">Select the products you'd like to showcase in the slideshow in the product page!</p>

      <div class="wrap upsell-products-container">
        <form action="options.php" method="post">
          <?php
          foreach ($categories_exist as $key => $val) {
          ?>
            <div class="container">
              <h3 class="categories-selected"><?php echo strtoupper($key[0]) . substr($key, 1) ?></h3>

              <div class="products-grid">
                <?php
                foreach ($val as $product) {
                  $checked = (isset($products_selected[$key][$product['product_name']]));
                ?>
                  <div class="product-container">
                    <div class="product-image">
                      <input type="checkbox" class="product-name" id="<?php echo $product['product_name'] ?>" name="<?php echo 'upsell_products[' . $key . '][' . $product['product_name'] . ']' ?>" <?php echo ($checked ? 'checked' : '') ?> value="<?php echo $product['product_id'] ?>">
                      <label for="<?php echo $product['product_name'] ?>"><?php echo $product['product_image'] ?></label>
                    </div>
                    <div class="product-attributes">
                      <p class="product-name"><?php echo $product['product_name'] ?></p>
                      <p class="product-price"><?php echo $product['product_price']  ?><span>$</span></p>
                      <p><?php echo ($product['product_type'] == 'grouped' ? 'Grouped Products' : 'Single Product') ?></p>
                    </div>

                  </div>
                <?php

                }
                ?>
              </div>
            </div>
          <?php
          }
          ?>
          <br class="line-breaker">
          <?php
          settings_fields('iucp_upsell_manager_settings');
          submit_button('Update Products', 'primary', 'submit', true);
          ?>
          <input type="hidden" name="update_products" value="1">
        </form>
      </div>

    </div>
  </div>


</div>