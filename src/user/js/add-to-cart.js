window.addEventListener("DOMContentLoaded", () => {
  const productsContainer = document.querySelector(".iucp-products-container");
  productsContainer.addEventListener("click", function (e) {
    e.preventDefault();
    const target = e.target.closest(".product-button");
    if (!target) return;
    addProductToCart(target.dataset.productId);
  });
});

async function addProductToCart(productID) {
  try {
    console.log(storeData.nonce);
    // const cartResponse = await fetch(
    //   `${storeData.siteUrl}/wp-json/wc/store/v1/cart/add-item`,
    //   {
    //     method: "POST",
    //     credentials: "same-origin",
    //     headers: {
    //       "X-WP-Nonce": storeData.nonce,
    //       "Content-Type": "application/json",
    //     },
    //     body: JSON.stringify(productID),
    //   }
    // );
    const cartResponse = await fetch(
      `${storeData.siteUrl}/wp-json/wc/store/v1/cart`
    );
    const res = await cartResponse.json();
    console.log(res);
  } catch (error) {}
}
