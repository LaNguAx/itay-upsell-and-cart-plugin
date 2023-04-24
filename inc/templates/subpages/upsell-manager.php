<div class="wrap upsell-manager">
  <h1></h1>
  <?php settings_errors();
  $categories = get_option('iucp_upsell_manager_categories');
  $products_found = get_option('iucp_upsell_products');
  ?>

  <ul class="nav nav-tabs">
    <li class="<?php echo (!$categories ? 'active' : '') ?>"><a href="#tab-1">Choose Categories</a></li>
    <li class="<?php echo ($categories ? 'active' : 'hidden') ?>"><a href="#tab-2">Select Products</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo (!$categories ? 'active' : '') ?>">
      <form method="post" action="options.php">
        <?php
        settings_fields('iucp_upsell_manager_settings');
        do_settings_sections('itay_upsell_manager');
        submit_button();
        ?>
      </form>
    </div>
    <div id="tab-2" class="tab-pane <?php echo ($categories ? 'active' : 'hidden') ?>">
      <h3 class="tab-heading">Select Products</h3>
      <p class="tab-subheading">Select the products you'd like to showcase in the slideshow in the product page!</p>

      <div class="wrap upsell-products-container">
        <form action="options.php" method="post">
          <?php
          foreach ($categories as $category_name => $term_id) {

          ?>
            <div class="container">
              <h3 class="categories-selected"><?php echo $category_name ?></h3>

              <div class="products-grid">
                <?php
                $get_products = wc_get_products(array(
                  'category' => $category_name
                ));
                foreach ($get_products as $product) {
                  $checked = isset($products_found[$category_name][$product->get_id()]);

                  $product_data = array(
                    'product_name' => $product->get_name(),
                    'product_type' => $product->get_type(),
                    'product_variation' => $product->is_type('variable') ? new WC_Product_Variation($product->get_id()) : null
                  );

                  if (!is_null($product_data['product_variation'])) {
                    print('<pre>' . print_r($product_data['product_variation'], true) . '</pre>');
                    die();
                    foreach ($product_data['product_variation'] as $variation_name => $variations) {
                      foreach ($variations as $variation) {
                        $product_data['product_variation'] = array($variation_name => $variation);
                        $product_data['product_price'] = $product->get_variation_prices()
                        // fix here
                ?>
                        <div class="product-container">
                          <div class="product-image">
                            <input type="checkbox" class="product-name" id="product-id" name="<?php echo 'new_products[' . $category_name . '][' . $product->get_id() . ']' ?>" value="<?php echo esc_attr(json_encode($product_data)) ?>" <?php echo ($checked ? 'checked' : '')  ?>>
                            <label for="product-id"><?php echo $product->get_image()  ?></label>
                          </div>
                          <div class="product-attributes">
                            <p class="product-name"><?php echo $product->get_name()  ?></p>
                            <p class="product-price"><?php echo $product->get_price() ?><span>$</span></p>
                            <p><?php  ?></p>
                            <p><?php echo $variation ?></p>
                          </div>
                        </div>
                    <?php
                      }
                    }
                  } else {
                    ?>
                    <div class="product-container">
                      <div class="product-image">
                        <input type="checkbox" class="product-name" id="product-id" name="<?php echo 'new_products[' . $category_name . '][' . $product->get_id() . ']'  ?>" value="1" <?php echo ($checked ? 'checked' : '')  ?>>
                        <label for="product-id"><?php echo $product->get_image()  ?></label>
                      </div>
                      <div class="product-attributes">
                        <p class="product-name"><?php echo $product->get_name()  ?></p>
                        <p class="product-price"><?php echo $product->get_price() ?><span>$</span></p>
                        <p><?php  ?></p>
                      </div>

                    </div>
                <?php
                  }
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