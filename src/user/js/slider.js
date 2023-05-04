import Glide from "@glidejs/glide";
// import AddToCart from "./add-to-cart";
class Slider {
  #mainCategorySlider;
  #productsSliders;
  #productsSlidersContainer;

  constructor() {
    this.events();
  }
  events() {
    window.addEventListener("DOMContentLoaded", () => {
      this.initializeVariables();

      this.initializeSliders();

      this.#mainCategorySlider.addEventListener("click", (e) => {
        this.handleCategorySliderClick(e);
      });
    });
  }
  initializeVariables() {
    this.#mainCategorySlider = document.querySelector(
      ".iucp-upsell-categories-container"
    );
    this.#productsSliders = document.querySelectorAll(
      ".glide.iucp-upsell-products-container"
    );
    this.#productsSlidersContainer = document.querySelector(
      ".icup-products-container"
    );
  }
  initializeSliders() {
    // Categories
    new Glide(".iucp-upsell-slider", {
      type: "carousel",
      direction: "rtl",
      perView: 4,
      gap: 15,
    }).mount();
    // Products
    document.body.append(this.#productsSlidersContainer);
    this.#productsSliders.forEach((slider) => {
      const sliderName = slider.getAttribute("id").split("_").slice(1)[0];
      new Glide(`.glide.iucp-upsell-slider.${sliderName}`, {
        type: "carousel",
        direction: "rtl",
        perView: 4,
        gap: 15,
      }).mount();
    });
  }
  handleCategorySliderClick(e) {
    const target = e.target.closest("li");
    if (!target) return;

    const clickedCategory = target.querySelector("a").getAttribute("href");
    this.showClickedCategory(clickedCategory.slice(1));
  }
  showClickedCategory(sliderName) {
    this.generateOverlay();
    const clickedSlider = document.querySelector(
      `#iucp-upsell-products-container_${sliderName}`
    );
    clickedSlider.classList.add("active");
  }
  generateOverlay() {
    const overlay = document.createElement("div");
    overlay.classList.add("iucp-upsell-overlay");
    document.body.appendChild(overlay);

    setTimeout(() => {
      overlay.classList.add("active");
    }, 50);
    this.toggleOverflow(true);

    overlay.addEventListener("click", (e) => {
      overlay.classList.remove("active");
      setTimeout(() => {
        overlay.remove();
      }, 200);
      this.toggleOverflow(false);
      this.hideAllProductSliders();
    });
  }
  toggleOverflow(state) {
    if (state) {
      document.body.style.overflow = "hidden";
      return;
    }
    document.body.style.overflow = "auto";
    return;
  }
  hideAllProductSliders() {
    // const productsSliders = document.querySelectorAll(
    //   ".glide.iucp-upsell-products-container"
    // );
    this.#productsSliders.forEach((slider) =>
      slider.classList.remove("active")
    );
  }
}

// Initialize functionalities.
const slider = new Slider();
// const addToCart = new AddToCart();
