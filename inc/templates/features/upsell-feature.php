<?php
$product_categories = array();
$products_within_categories = array();
$iucp_upsell_products = get_option('iucp_upsell_products');

foreach ($iucp_upsell_products as $category => $product) {
  $product_categories[] = $category;
  $products_within_categories[$category] = $product;
}
if (!$iucp_upsell_products) return;
?>
<div class="iucp-category-container">
  <div id="iucp-upsell-main-category-container" class="glide iucp-upsell-categories-container">
    <div class="glide iucp-upsell-slider">
      <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
          <?php
          foreach ($product_categories as $category) {
            $first_product = reset($products_within_categories[$category]);
            $first_product_data = wc_get_product($first_product);
          ?>
            <li id="<?php echo $category ?>" class="glide__slide">
              <div class="product-container">
                <div class="product-image"><?php echo $first_product_data->get_image() ?></div>
                <p class="product-name"><?php echo strtoupper($category[0]) . substr($category, 1) ?></p>
                <span class="product-button"><a href="#<?php echo $category ?>">View Additions</a></span>
              </div>
            </li>
          <?php
          }
          ?>
        </ul>
      </div>
      <div class="glide__arrows" data-glide-el="controls">
        <button class="glide__arrow glide__arrow--left iucp" data-glide-dir="<">prev</button>
        <button class="glide__arrow glide__arrow--right iucp" data-glide-dir=">">next</button>
      </div>
    </div>
  </div>
</div>
<div class="iucp-products-container">
  <?php
  foreach ($products_within_categories as $category => $products) {
  ?>
    <div id="iucp-upsell-products-container_<?php echo $category ?>" class="glide iucp-upsell-products-container">
      <div class="glide iucp-upsell-slider <?php echo $category ?>">
        <div class="glide__track" data-glide-el="track">
          <ul class="glide__slides">
            <?php
            foreach ($products as $product) {
              $current_product = wc_get_product($product);
              $current_product_attr = $current_product->get_default_attributes();
            ?>
              <li id="<?php echo $category ?>" class="glide__slide">
                <form class="product-container">
                  <div class="product-image"><?php echo $current_product->get_image() ?></div>
                  <p class="product-name"><?php echo $current_product->get_name() ?></p>
                  <p class="product-price"><?php echo $current_product->get_price() . get_woocommerce_currency_symbol() ?></p>
                  <span class="product-button" data-product-type="<?php echo $current_product->get_type() ?>" data-product-id="<?php echo $current_product->get_id() ?>">
                    <?php
                    if ($current_product->is_type('variable')) {
                    ?>

                      <pre id="product-attributes" class="hidden"><?php echo json_encode($current_product_attr) ?></pre>
                    <?php
                    }
                    ?>
                    <a href="<?php echo $current_product->add_to_cart_url() ?>"><?php echo ($current_product->is_type('grouped') ? 'View Products' : 'Add To Cart') ?></a>
                    <span class="lds-dual-ring hidden"></span>
                    <span class="add-to-cart-success hidden">Item Added To Cart!</span>
                  </span>
                </form>
              </li>

            <?php
            }
            ?>
          </ul>
        </div>
        <div class="glide__arrows" data-glide-el="controls">
          <button class="glide__arrow glide__arrow--left iucp" data-glide-dir="<">prev</button>
          <button class="glide__arrow glide__arrow--right iucp" data-glide-dir=">">next</button>
        </div>
      </div>
    </div>
  <?php
  }
  ?>
</div>