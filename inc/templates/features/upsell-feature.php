<?php
$product_categories = array();
$products_within_categories = array();

$iucp_upsell_products = get_option('iucp_upsell_products');
$iucp_upsell_options = get_option('iucp_upsell_manager_options');

foreach ($iucp_upsell_products as $category => $product) {
  $product_categories[] = $category;
  $products_within_categories[$category] = $product;
}
// print('<pre>' . print_r($product_categories, true) . '</pre>');
// print('<pre>' . print_r($products_within_categories, true) . '</pre>');
// die();
if (!$iucp_upsell_products) return;
?>
<div class="iucp-category-container" style="background-color: <?php echo (isset($iucp_upsell_options['iucp_category_container_background_color']) ? $iucp_upsell_options['iucp_category_container_background_color'] : '') ?>;">
  <div class="iucp-headers-wrap">
    <h4 class="iucp-upsell-heading" style="color: <?php echo (isset($iucp_upsell_options['iucp_upsell_heading_text_color']) ? $iucp_upsell_options['iucp_upsell_heading_text_color'] : '') ?>"><?php echo isset($iucp_upsell_options['iucp_upsell_heading']) ? $iucp_upsell_options['iucp_upsell_heading'] : '' ?></h4>
    <h5 class="iucp-upsell-subheading" style="color: <?php echo (isset($iucp_upsell_options['iucp_upsell_subheading_text_color']) ? $iucp_upsell_options['iucp_upsell_subheading_text_color'] : '') ?>"><?php echo isset($iucp_upsell_options['iucp_upsell_subheading']) ? $iucp_upsell_options['iucp_upsell_subheading'] : '' ?></h5>
  </div>
  <div id="iucp-upsell-main-category-container" class="glide iucp-upsell-categories-container">
    <h4></h4>
    <h5></h5>
    <div class="glide iucp-upsell-slider">
      <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
          <?php
          foreach ($product_categories as $category) {
            $first_product = array_key_first($products_within_categories[$category]);
            $first_product_data = wc_get_product($first_product);
          ?>
            <li id="<?php echo $category ?>" class="glide__slide">
              <div class="product-container">
                <div class="product-image"><?php echo $first_product_data->get_image() ?></div>
                <p class="product-name"><?php echo strtoupper($category[0]) . substr($category, 1) ?></p>
                <button style="background-color: <?php echo isset($iucp_upsell_options['iucp_upsell_category_button_background_color']) ? $iucp_upsell_options['iucp_upsell_category_button_background_color'] : '' ?>" class="product-button"><a style=" color: <?php echo isset($iucp_upsell_options['iucp_upsell_category_button_text_color']) ? $iucp_upsell_options['iucp_upsell_category_button_text_color'] : ''  ?>;" href="#<?php echo $category ?>"><?php echo isset($iucp_upsell_options['iucp_category_button_text']) ? $iucp_upsell_options['iucp_category_button_text'] : '' ?></a></button>
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
            foreach ($products as $product_id => $product) {
              $current_product = wc_get_product($product_id);
            ?>
              <li id="<?php echo $category ?>" class="glide__slide">
                <form class="product-container">
                  <div class="product-image"><?php echo $current_product->get_image() ?></div>
                  <p class="product-name"><?php echo $current_product->get_name() ?></p>
                  <div id="product-attributes-container">
                    <p class="product-price"><?php echo $current_product->get_price() . get_woocommerce_currency_symbol() ?></p>
                    <a style="background-color: <?php echo isset($iucp_upsell_options['iucp_upsell_product_button_background_color']) ?  $iucp_upsell_options['iucp_upsell_product_button_background_color'] : '' ?>;" href="?add-to-cart=<?php echo $current_product->get_id() ?>" data-quantity="1" class="product-button button wp-element-button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $current_product->get_id() ?>" data-product_sku="" aria-label="<?php echo $current_product->get_name() ?>" rel="nofollow">Add to cart</a>
                    <?php /* <button style="background-color: <?php echo isset($iucp_upsell_options['iucp_upsell_product_button_background_color']) ?  /$iucp_upsell_options['iucp_upsell_product_button_background_color'] : '' ?>;" class="product-button" data-product-type="<?php echo $current_product->get_type() ?>" data-product-id="<?php echo $current_product->get_id() ?>">
                      <a style=" color: <?php echo isset($iucp_upsell_options['iucp_upsell_product_button_text_color']) ? $iucp_upsell_options['iucp_upsell_product_button_text_color'] : ''  ?>;" href="<?php echo $current_product->add_to_cart_url() ?>"><?php echo isset($iucp_upsell_options['iucp_product_button_text']) ? $iucp_upsell_options['iucp_product_button_text'] : '' ?></a>
                      <span class="lds-dual-ring hidden"></span>
                      <span class="add-to-cart-success hidden" style=" color: <?php echo isset($iucp_upsell_options['iucp_upsell_product_button_text_color']) ? $iucp_upsell_options['iucp_upsell_product_button_text_color'] : ''  ?>;"><?php echo isset($iucp_upsell_options['iucp_product_add_to_cart_success']) ? $iucp_upsell_options['iucp_product_add_to_cart_success'] : '' ?></span>
                    </button> */ ?>
                  </div>
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