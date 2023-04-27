window.addEventListener("DOMContentLoaded", () => {
  const productsContainer = document.querySelector(".iucp-products-container");
  productsContainer.addEventListener("click", async function (e) {
    try {
      e.preventDefault();
      const target = e.target.closest(".product-button");
      if (!target) return;
      if (target.dataset.productType == "grouped") {
        const groupedProducts = target.querySelector("a").href;
        window.location.href = groupedProducts;
        return;
      }

      // const check = await fetch(
      //   `${storeData.siteUrl}/wp-json/wc/store/v1/cart`
      // );
      // const data = await check.json();
      // console.log(data);
      showSpinner(target);
      const response = await addProductToCart(target.dataset.productId, target);
      showSpinner(target);
      showSuccessMessage(target);
    } catch (error) {
      console.log(error);
    }
  });
});

async function addProductToCart(productID, target) {
  try {
    const product = {
      id: productID,
      quantity: 1,
      variation: undefined,
    };

    console.log(target);
    const productVariation = target.querySelector("#product-attributes")
      ? JSON.parse(target.querySelector("#product-attributes").value)
      : undefined;

    if (productVariation) {
      let newVariation = [];
      for (const [key, val] of Object.entries(productVariation)) {
        newVariation.push({
          attribute: key,
          value: val,
        });
      }
      product.variation = newVariation;
    }
    const fetchUrl = `${storeData.siteUrl}/wp-json/wc/store/v1/cart/add-item`;

    const cartResponse = await fetch(fetchUrl, {
      method: "POST",
      credentials: "same-origin",
      headers: {
        "X-WC-Store-API-Nonce": storeData.nonce,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(product),
    });

    if (!cartResponse.ok) return console.log(cartResponse);
    const res = await cartResponse.json();
    console.log(res);
  } catch (error) {
    throw error;
    console.log(error);
  }
}

function showSpinner(target) {
  const productButton = target;
  productButton.querySelector("a").classList.toggle("hidden");
  productButton.querySelector(".lds-dual-ring").classList.toggle("hidden");
}

function showSuccessMessage(target) {
  const productButton = target;
  productButton.querySelector("a").classList.toggle("hidden");
  productButton
    .querySelector(".add-to-cart-success")
    .classList.toggle("hidden");

  setTimeout(() => {
    productButton.querySelector("a").classList.toggle("hidden");
    productButton
      .querySelector(".add-to-cart-success")
      .classList.toggle("hidden");
  }, 1000);
}
