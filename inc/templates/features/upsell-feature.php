<div id="slider">
  <?
  $product_categories = array();
  $products_within_categories = array();
  $iucp_upsell_products = get_option('iucp_upsell_products');

  foreach ($iucp_upsell_products as $category => $product) {
    $product_categories[] = $category;
    $products_within_categories[$category] = $product;
  }

  ?>
  <section class="slider-container">
    <div class="slider">
      <?php
      foreach ($product_categories as $category) {
      ?>
        <div class="slider-item">
          <div class="slide">
            <figure class="slide-image">
              <?php
              $first_product = reset($products_within_categories[$category]);
              $first_product_details = wc_get_product($first_product);
              echo $first_product_details->get_image();
              ?>
            </figure>
            <h4 class="slide-name"><?php echo strtoupper($category[0]) . substr($category, 1) ?></h4>
            <div class="custom-line"></div>
            <div class="row">
              <strong>•</strong>
              <p><?php echo count($products_within_categories[$category]) ?> Products</p>
            </div>
            <div class="custom-line"></div>
            <div class="row custom-row">
              <!-- <p>$50</p> -->
              <a href="#<?php echo $category ?>"><span>&plus;</span></a>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </section>
  <button class="slider-btn btn-left">&leftarrow;</button>
  <button class="slider-btn btn-right">&rightarrow;</button>
</div>

<div class="upsell-overlay">
  <?php
  foreach ($products_within_categories as $category => $products) {
  ?>
    <div id="slider" class="<?php echo $category ?> subslider hidden">
      <section class="slider-container">
        <div class="slider">
          <?php
          foreach ($products as $product) {
            $current_product = wc_get_product($product);
          ?>
            <div class="slider-item">
              <div class="slide">
                <figure class="slide-image">
                  <?php echo $current_product->get_image() ?>
                </figure>
                <h4 class="slide-name"><?php echo $current_product->get_name() ?></h4>
                <div class="custom-line"></div>
                <div class="row">
                  <strong>•</strong>
                  <p>Add to cart<br>by pressing the button below</p>
                </div>
                <div class="custom-line"></div>
                <div class="row custom-row">
                  <p>$<?php echo $current_product->get_price() ?></p>
                  <a href="#"><span class="open-slider-button">&plus;</span></a>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </section>
      <button class="slider-btn btn-left">&leftarrow;</button>
      <button class="slider-btn btn-right">&rightarrow;</button>
    </div>

  <?php
  }
  ?>
</div>
<!-- <div id="slider" class="hidden">
  <section class="slider-container">
    <div class="slider">
      <div class="slider-item">
        <div class="slide">
          <figure class="slide-image">
            <img src="https://imgurl.ir/uploads/d366681_food_1.png" alt="">
          </figure>
          <h4 class="slide-name">Food Name</h4>
          <div class="custom-line"></div>
          <div class="row">
            <p>60 Calories</p>
            <strong>•</strong>
            <p>4 Persons</p>
          </div>
          <div class="custom-line"></div>
          <div class="row custom-row">
            <p>$50</p>
            <a href="#"><span>&plus;</span></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <button class="slider-btn btn-left">&leftarrow;</button>
  <button class="slider-btn btn-right">&rightarrow;</button>
</div> -->
<!-- 
  <div class="slider-item">
        <div class="slide">
          <figure class="slide-image">
            <img src="https://imgurl.ir/uploads/d366681_food_1.png" alt="">
          </figure>
          <h4 class="slide-name">Food Name</h4>
          <div class="custom-line"></div>
          <div class="row">
            <p>60 Calories</p>
            <strong>•</strong>
            <p>4 Persons</p>
          </div>
          <div class="custom-line"></div>
          <div class="row custom-row">
            <p>$50</p>
            <a href="#"><span>&plus;</span></a>
          </div>
        </div>
      </div>
 -->