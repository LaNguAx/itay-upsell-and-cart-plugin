window.addEventListener("DOMContentLoaded", () => {
  const navTabContainer = document.querySelector(".nav.nav-tabs");
  if (navTabContainer) {
    navTabContainer.addEventListener("click", function (e) {
      e.preventDefault();
      const target = e.target.closest("li");
      if (!target) return;
      const targetPaneID = target.firstElementChild.getAttribute("href");

      const navTabs = document.querySelectorAll(".nav.nav-tabs > li");
      navTabs.forEach((navTab) => navTab.classList.remove("active"));

      const tabs = document.querySelectorAll(".tab-pane");
      tabs.forEach((tab) => tab.classList.remove("active"));
      const clickedTab = document.querySelector(targetPaneID);

      target.classList.add("active");
      clickedTab.classList.add("active");
    });
    // Navigation tabs end

    // Validate checked inputs to send to db.
    const productsContainer = document.querySelector(
      ".wrap.upsell-products-container"
    );
    productsContainer.addEventListener("click", function (e) {
      console.log(e.target);
      const target = e.target.closest(".product-image");
      if (!target) return;
      manipulateClickedProductInputs(target);
    });
  }
});

function manipulateClickedProductInputs(target) {
  const inputs = target.querySelectorAll(".product-variation-attributes");
  inputs.forEach((input) => {
    input.type = input.type === "checkbox" ? "hidden" : "checkbox";
  });
}
