// Irrelevant because I made the product work with the built-in add to cart ajax of woocoommerce.
class AddToCart {
  #requestSent;
  #productsContainer;
  #fetchURL;

  constructor() {
    this.events();
  }
  events() {
    window.addEventListener("DOMContentLoaded", () => {
      this.initializeVariables();

      this.#productsContainer.addEventListener("click", (e) =>
        this.handleProductButtonClick(e)
      );
    });
  }
  initializeVariables() {
    this.#productsContainer = document.querySelector(
      ".iucp-products-container"
    );
    this.#requestSent = false;
    this.#fetchURL = `${storeData.siteUrl}/wp-json/wc/store/v1/cart/add-item`;
  }
  async handleProductButtonClick(e) {
    try {
      e.preventDefault();
      const target = e.target.closest(".product-button");
      if (!target) return;
      if (target.dataset.productType == "grouped") {
        const groupedProducts = target.querySelector("a").href;
        window.location.href = groupedProducts;
        return;
      }

      if (this.#requestSent) return;
      this.#requestSent = true;
      console.log(target);
      this.showSpinner(target);
      const response = await this.addProductToCart(target.dataset.product_id);
      this.showSpinner(target);
      this.showSuccessMessage(target);
    } catch (error) {
      console.log(error);
    }
  }
  async addProductToCart(productID) {
    try {
      const cartResponse = await fetch(this.#fetchURL, {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "X-WC-Store-API-Nonce": storeData.nonce,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id: productID,
          quantity: 1,
        }),
      });

      if (!cartResponse.ok) return console.log(cartResponse);
      const res = await cartResponse.json();
      console.log(res);
      return res;
    } catch (error) {
      throw error;
    }
  }
  showSpinner(productButton) {
    productButton.classList.toggle("hidden");
    // productButton.querySelector(".lds-dual-ring").classList.toggle("hidden");
  }

  showSuccessMessage(productButton) {
    productButton.querySelector("a").classList.toggle("hidden");
    productButton
      .querySelector(".add-to-cart-success")
      .classList.toggle("hidden");

    setTimeout(() => {
      productButton.querySelector("a").classList.toggle("hidden");
      productButton
        .querySelector(".add-to-cart-success")
        .classList.toggle("hidden");

      this.#requestSent = false;
    }, 1000);
  }
}

export default AddToCart;

// Code that is not structured in OOP.
// let requestSent = false;
// window.addEventListener("DOMContentLoaded", () => {
//   const productsContainer = document.querySelector(".iucp-products-container");
//   productsContainer.addEventListener("click", async function (e) {
//     try {
//       e.preventDefault();
//       const target = e.target.closest(".product-button");
//       if (!target) return;
//       if (target.dataset.productType == "grouped") {
//         const groupedProducts = target.querySelector("a").href;
//         window.location.href = groupedProducts;
//         return;
//       }

//       if (requestSent) return;
//       requestSent = true;
//       showSpinner(target);
//       const response = await addProductToCart(target.dataset.productId, target);
//       showSpinner(target);
//       showSuccessMessage(target);
//     } catch (error) {
//       console.log(error);
//     }
//   });
// });

// async function addProductToCart(productID) {
//   try {
//     /**
//      * This code becomes irrelevant after I figured out you can simply pass the variation ID (Which is technically a product ID) and that does all the logic for you, so you don't need to send an array of the variations, only variation ID.
//      *
//     const product = {
//       id: productID,
//       quantity: 1,
//       variation: undefined,
//     };
//     // const productVariation = target.querySelector("#product-attributes")
//     //   ? JSON.parse(target.querySelector("#product-attributes").value)
//     //   : undefined;

//     // if (productVariation) {
//     //   let newVariation = [];
//     //   for (const [key, val] of Object.entries(productVariation)) {
//     //     newVariation.push({
//     //       attribute: key,
//     //       value: val,
//     //     });
//     //   }
//     //   product.variation = newVariation;
//     // } */
//     const fetchUrl = `${storeData.siteUrl}/wp-json/wc/store/v1/cart/add-item`;
//     const cartResponse = await fetch(fetchUrl, {
//       method: "POST",
//       credentials: "same-origin",
//       headers: {
//         "X-WC-Store-API-Nonce": storeData.nonce,
//         "Content-Type": "application/json",
//       },
//       body: JSON.stringify({
//         id: productID,
//         quantity: 1,
//       }),
//     });

//     if (!cartResponse.ok) return alert(cartResponse);
//     const res = await cartResponse.json();
//     return res;
//   } catch (error) {
//     throw error;
//     console.log(error);
//   }
// }

// function showSpinner(target) {
//   const productButton = target;
//   productButton.querySelector("a").classList.toggle("hidden");
//   productButton.querySelector(".lds-dual-ring").classList.toggle("hidden");
// }

// function showSuccessMessage(target) {
//   const productButton = target;
//   productButton.querySelector("a").classList.toggle("hidden");
//   productButton
//     .querySelector(".add-to-cart-success")
//     .classList.toggle("hidden");

//   setTimeout(() => {
//     productButton.querySelector("a").classList.toggle("hidden");
//     productButton
//       .querySelector(".add-to-cart-success")
//       .classList.toggle("hidden");

//     requestSent = false;
//   }, 1000);
// }
