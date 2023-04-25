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
                    'product_variations' => $product->is_type('variable') ? $product->get_variation_attributes() : null
                  );
                  if (!is_null($product_data['product_variations'])) {
                    foreach ($product_data['product_variations'] as $variation_name => $variations) {
                      foreach ($variations as $variation) {
                        $product_data['product_variations'] = array($variation_name => $variation);
                        // print('<pre>' . print_r($product_data, true) . '</pre>');
                        $checkedVariation;
                        // FIX HERE WHEN LOADING THE PAGE IT DOESNT RENDER CORRECTLY THE CHECKED FOR THE CHECKBOXES!! BECAUSE YOU HAVE MULTIPLE CHECKBOXES FOR EACH ITEM AND YOU JUST CHECK WETHER OR NOT THAT ITEMS EXIST AND YOU SHOULD CHECK FOR WETHER VARIATION EXISTS!!!
                        if ($checked) {
                          // print('<pre>' . print_r($products_found, true) . '</pre>');
                          // die();
                          $checkedVariation = isset($products_found[$category_name][$product->get_id()]['product_variations'][$variation_name][$variation]);
                          print('<pre>' . print_r($products_found[$category_name][$product->get_id()]['product_variations'][$variation_name], true) . '</pre>');
                          die();
                        }
                ?>
                        <div class="product-container">
                          <div class="product-image">
                            <input type="checkbox" class="product-name" id="product-id" name="<?php echo 'new_products[' . $category_name . '][' . $product->get_id() . '][product_name]' ?>" value="<?php echo $product_data['product_name'] ?>" <?php echo ($checked ? 'checked' : '')  ?>>
                            <label for="product-id"><?php echo $product->get_image()  ?></label>

                            <div class="product-variations hidden">
                              <input class="product-variation-attributes" type="<?php echo ($checked ? 'hidden' : 'checkbox')  ?>" name="<?php echo 'new_products[' . $category_name . '][' . $product->get_id() . '][product_type]' ?>" value="<?php echo $product_data['product_type'] ?>">

                              <input class="product-variation-attributes" type="<?php echo ($checked ? 'hidden' : 'checkbox')  ?>" name="<?php echo 'new_products[' . $category_name . '][' . $product->get_id() . '][product_variations][' . $variation_name . '][]' ?>" value="<?php echo $product_data['product_variations'][$variation_name] ?>">
                            </div>
                          </div>
                          <div class="product-attributes">
                            <p class="product-name"><?php echo $product->get_name()  ?></p>
                            <p class="product-price"><?php echo $product->get_price() ?><span>$</span></p>
                            <p><?php echo $product->get_type()  ?></p>
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
                        <input type="checkbox" class="product-name" id="product-id" name="<?php echo 'new_products[' . $category_name . '][' . $product->get_id() . ']'  ?>" value="<?php echo $product->get_name() ?>" <?php echo ($checked ? 'checked' : '')  ?>>
                        <label for="product-id"><?php echo $product->get_image()  ?></label>
                      </div>
                      <div class="product-attributes">
                        <p class="product-name"><?php echo $product->get_name()  ?></p>
                        <p class="product-price"><?php echo $product->get_price() ?><span>$</span></p>
                        <p><?php echo $product->get_type() ?></p>
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