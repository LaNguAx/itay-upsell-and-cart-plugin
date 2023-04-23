<?php
$product_categories = array();
$products_within_categories = array();
$iucp_upsell_products = get_option('iucp_upsell_products');

foreach ($iucp_upsell_products as $category => $product) {
  $product_categories[] = $category;
  $products_within_categories[$category] = $product;
}
?>

<div class="glide iucp-upsell-categories-container">
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
      <button class="glide__arrow glide__arrow--left" data-glide-dir="<">prev</button>
      <button class="glide__arrow glide__arrow--right" data-glide-dir=">">next</button>
    </div>
  </div>
</div>

<?php
foreach ($products_within_categories as $category => $products) {
?>
  <div class="glide iucp-upsell-products-container">
    <div class="glide iucp-upsell-slider <?php echo $category ?>">
      <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
          <?php
          foreach ($products as $product) {
            $current_product = wc_get_product($product);
          ?>
            <li id="<?php echo $category ?>" class="glide__slide">
              <div class="product-container">
                <div class="product-image"><?php echo $current_product->get_image() ?></div>
                <p class="product-name"><?php echo $current_product->get_name() ?></p>
                <span class="product-button"><a href="#<?php echo $category ?>">View Additions</a></span>
              </div>
            </li>

          <?php
          }
          ?>
        </ul>
      </div>
      <div class="glide__arrows" data-glide-el="controls">
        <button class="glide__arrow glide__arrow--left" data-glide-dir="<">prev</button>
        <button class="glide__arrow glide__arrow--right" data-glide-dir=">">next</button>
      </div>
    </div>
  </div>
<?php
}
?>