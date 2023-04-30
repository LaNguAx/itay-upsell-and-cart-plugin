/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./src/user/js/cart.js ***!
  \*****************************/
class Cart {
  #cartToggled = false;
  #cartBtn;
  #cartContainer;
  cartState = {
    products: []
  };
  constructor() {
    this.events();
  }
  events() {
    window.addEventListener("DOMContentLoaded", () => {
      this.initializeVariables();
      this.#cartBtn.addEventListener("click", e => {
        this.toggleCart();
      });
    });
  }
  initializeVariables() {
    this.#cartContainer = document.querySelector(".iucp-cart-feature-container");
    this.#cartBtn = document.querySelector(".iucp-cart-feature-toggle-cart-button");
  }
  toggleCart() {
    this.#cartContainer.classList.toggle("inactive");
    this.#cartToggled = this.cartToggled ? false : true;
  }
}
const cart = new Cart();
console.log("test");
/******/ })()
;
//# sourceMappingURL=cart.js.map