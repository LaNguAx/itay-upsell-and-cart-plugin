/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./src/admin/js/upsell-manager.js ***!
  \****************************************/
window.addEventListener("DOMContentLoaded", function () {
  const navTabContainer = document.querySelector(".nav.nav-tabs");
  if (navTabContainer) {
    navTabContainer.addEventListener("click", function (e) {
      e.preventDefault();
      const target = e.target.closest("li");
      if (!target) return;
      const targetPaneID = target.firstElementChild.getAttribute("href");
      const navTabs = document.querySelectorAll(".nav.nav-tabs > li");
      navTabs.forEach(navTab => navTab.classList.remove("active"));
      const tabs = document.querySelectorAll(".tab-pane");
      tabs.forEach(tab => tab.classList.remove("active"));
      const clickedTab = document.querySelector(targetPaneID);
      target.classList.add("active");
      clickedTab.classList.add("active");
    });
  }
});
/******/ })()
;
//# sourceMappingURL=upsell-manager.js.map