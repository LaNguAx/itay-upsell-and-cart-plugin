import Glide from "@glidejs/glide";
let categoryPressed;
window.addEventListener("DOMContentLoaded", function (e) {
  // Categories sliders start.
  const categorySlider = document.querySelector(
    ".glide.iucp-upsell-categories-container"
  );
  if (categorySlider) {
    categorySlider.addEventListener("click", function (e) {
      e.preventDefault();
      handleCategorySliderClick(e);
    });
    new Glide(".glide.iucp-upsell-slider", {
      type: "carousel",
      perView: 4,
      gap: 15,
    }).mount();
  }
  // Categories slider end.

  //Products sliders start
  const productsSliders = document.querySelectorAll(
    ".glide.iucp-upsell-products-container"
  );
  if (productsSliders) {
    productsSliders.forEach((slider) => {
      slider.addEventListener("click", function (e) {
        e.preventDefault();
      });
      document.body.append(slider);
      // slider.classList.add(sliderName, "hidden");

      const sliderName = slider.querySelector(".glide.iucp-upsell-slider")
        .classList[2];

      const glide = new Glide(`.glide.iucp-upsell-slider.${sliderName}`, {
        type: "carousel",
        perView: 4,
        gap: 15,
      }).mount();
    });
  }
  // Products sliders end
});

function handleCategorySliderClick(e) {
  const target = e.target.closest("li");
  if (!target) return;

  const clickedCategory = target.querySelector("a").getAttribute("href");
  categoryPressed = true;
  showClickedCategory(clickedCategory.slice(1));
  return;
}

function showClickedCategory(categoryName) {
  if (!categoryPressed) return;
  generateOverlay();
}

function generateOverlay() {
  const overlay = document.createElement("div");
  overlay.classList.add("iucp-upsell-overlay");
  document.body.appendChild(overlay);

  setTimeout(() => {
    overlay.classList.add("active");
  }, 50);
  toggleOverflow(true);

  overlay.addEventListener("click", function (e) {
    overlay.classList.remove("active");
    setTimeout(() => {
      overlay.remove();
    }, 200);
    toggleOverflow(false);
  });
}

function toggleOverflow(state) {
  if (state) {
    document.body.style.overflow = "hidden";
    return;
  }
  document.body.style.overflow = "auto";
  return;
}
