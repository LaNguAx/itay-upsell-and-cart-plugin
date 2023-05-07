<div class="wrap upsell-manager">
  <h1></h1>
  <?php
  settings_errors();
  $categories = get_option('iucp_upsell_manager_categories');
  $products_found = get_option('iucp_upsell_products');
  ?>

  <ul class="nav nav-tabs">
    <li class="<?php echo (!$categories ? 'active' : '') ?>"><a href="#tab-1">Choose Categories</a></li>
    <li class="<?php echo ($categories ? 'active' : 'hidden') ?>"><a href="#tab-2">Select Products</a></li>
    <li class="<?php echo ($categories ? '' : 'hidden') ?>"><a href="#tab-3">Upsell Options</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo (!$categories ? 'active' : '') ?>">
      <form method="post" action="options.php">
        <?php
        settings_fields('iucp_upsell_manager_settings');
        do_settings_sections('itay_upsell_manager');
        submit_button();
        ?>
        <input type="hidden" name="varname" value="var_value">

      </form>
    </div>
    <div id="tab-2" class="tab-pane <?php echo ($categories ? 'active' : 'hidden') ?> ">
      <h3 class="tab-heading">Select Products</h3>
      <p class="tab-subheading">Select the products you'd like to showcase in the slideshow in the product page!</p>

      <div class="wrap upsell-products-container">
        <form action="options.php" method="post">
          <?php
          if ($categories)
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
                  $product_children = $product->get_children();
                  $products_data = array();
                  // if it's a variable product with children
                  if (count($product_children)) {
                    foreach ($product_children as $child) {
                      $product_child = wc_get_product($child);
                      $product_id = $product_child->get_id();
                      $products_data[$product_id] = array(
                        'product_id' => $product_child->get_id(),
                        'product_name' => $product_child->get_name(),
                        'product_variations' => $product_child->get_attributes(),
                        'product_type' => $product_child->get_type()
                      );
                      $first_arr_key = array_key_first($products_data[$product_id]['product_variations']);
                      // print('<pre>' . print_r(, true) . '</pre>');
                      // print('<pre>' . print_r($category_name, true) . '</pre>');
                      // print('<pre>' . print_r($product_id, true) . '</pre>');
                      // die();

                      if (!is_object($products_data[$product_id]['product_variations'][$first_arr_key])) {
                        $checked = isset($products_found[$category_name][$product_id]);
                        // If the product has variations

                        $product_variations = $products_data[$product_id]['product_variations'];
                ?>

                        <div class="product-container">
                          <div class="product-image">
                            <input type="checkbox" class="product-name" id="product-id" name="<?php echo 'new_products[' . $category_name . '][' . $product_id . '][product_name]' ?>" value="<?php echo $products_data[$product_id]['product_name'] ?>" <?php echo ($checked ? 'checked' : '')  ?>>
                            <label for="product-id"><?php echo $product_child->get_image()  ?></label>

                            <div class="product-variations hidden">
                              <input class="product-variation-attributes" type="<?php echo ($checked ? 'hidden' : 'checkbox')  ?>" name="<?php echo 'new_products[' . $category_name . '][' . $product_id . '][product_type]' ?>" value="<?php echo $products_data[$product_id]['product_type'] ?>">



                              <?php
                              $variations_html = '';
                              foreach ($product_variations as $variation_name => $variation_value) {
                                $variations_html .= $variation_name . ' = ' . $variation_value . '<br>';
                              ?>
                                <input class="product-variation-attributes" type="<?php echo ($checked ? 'hidden' : 'checkbox')  ?>" name="<?php echo 'new_products[' . $category_name . '][' . $product_id . '][product_variations][' . $variation_name . ']' ?>" value="<?php echo $products_data[$product_id]['product_variations'][$variation_name] ?>">
                              <?php } ?>
                            </div>
                          </div>
                          <div class="product-attributes">
                            <p class="product-name"><?php echo $products_data[$product_id]['product_name']  ?></p>
                            <p class="product-price"><?php echo $product_child->get_price() ?><span>$</span></p>
                            <p><?php echo $products_data[$product_id]['product_type'] . ' product' ?></p>
                            <p><?php echo $variations_html ?></p>
                          </div>
                        </div>



                    <?php

                      }
                    }
                  } else {
                    // If it's a simple product with no children
                    $checked = isset($products_found[$category_name][$product->get_id()]);

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
    <div id="tab-3" class="tab-pane">
      <div class="wrap upsell-manager-options">
        <form action="
      options.php" method="post">
          <?php
          settings_fields('iucp_upsell_manager_options_group');
          do_settings_sections('itay_upsell_manager#tab-3');
          ?>
          <div class="iucp-flex">
            <?php
            submit_button();
            submit_button('Reset', 'secondary', 'submit');
            ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php

/**
 *
 * 
 * 
                  $checked = isset($products_found[$category_name][$product->get_id()]);


                  $product_data = array(
                    'product_name' => $product->get_name(),
                    'product_type' => $product->get_type(),
                    'product_variations' => $product->is_type('variable') ? $product->get_variation_attributes() : null
                  );
                  if (!is_null($product_data['product_variations'])) {

                    $product_variations = $product->get_children();
                    $product_variations_in_db = isset($products_found[$category_name][$product->get_id()]['product_variations']) ? $products_found[$category_name][$product->get_id()]['product_variations'] : null;

                    foreach ($product_data['product_variations'] as $variation_name => $variations) {
                      foreach ($variations as $variation) {
                        $product_data['product_variations'] = array($variation_name => $variation);

                        $checked = isset($product_variations_in_db[$variation_name]) ?  in_array($variation, $product_variations_in_db[$variation_name]) : null;



                        // print('<pre>' . print_r($product->get_id(), true) . '</pre>');
                        // print('<pre>' . print_r($products_children->get_variation_attributes(), true) . '</pre>');
                ?>
                        <div class="product-container">
                          <div class="product-image">
                            <input type="checkbox" class="product-name" id="product-id" name="<?php echo 'new_products[' . $category_name . '][' . $product->get_id() . '][product_name]' ?>" value="<?php echo $product_data['product_name'] ?>" <?php echo ($checked ? 'checked' : '') ?>>
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
 * 
 * */
