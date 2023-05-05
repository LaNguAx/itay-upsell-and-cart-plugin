/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./src/admin/js/cart-manager.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
class CartManager {
  #timeZonesContainer;
  #timeZonesInputs;
  #addTimeZoneBtn;
  #deleteTimeZoneBtn;
  constructor() {
    window.addEventListener("DOMContentLoaded", () => {
      this.initializeVariables();
      this.events();
    });
  }
  events() {
    // add time zone
    this.#addTimeZoneBtn.addEventListener("click", e => {
      e.preventDefault();
      this.addTimeZone();
    });

    // delete time zone
    this.#timeZonesContainer.addEventListener("click", e => {
      const target = e.target.closest("#iucp-delete-time-zone-button");
      if (!target) return;
      e.preventDefault();
      this.deleteTimeZone(target);
    });

    // Time change
    this.#timeZonesInputs.forEach(element => {
      element.addEventListener("input", () => {
        this.timeChanged(element);
      });
    });
  }
  timeChanged(element) {
    const parent = element.parentElement.parentElement;
    element.setAttribute("value", element.value);
    const startTime = parent.querySelector("#start-time").value;
    parent.querySelectorAll(".iucp-time-zone-input").forEach(element => {
      element.setAttribute("name", `iucp_cart_manager_options[iucp_cart_time_zones][${startTime}]`);
    });
    if (element.id === "start-time") {
      parent.querySelector("#end-time").setAttribute("min", element.value);
    } else {
      parent.querySelector("#start-time").setAttribute("max", element.value);
    }
  }
  initializeVariables() {
    this.#timeZonesContainer = document.querySelector("#iucp_cart_time_zones");
    this.#timeZonesInputs = this.#timeZonesContainer.querySelectorAll(".iucp-time-zone-input");
    this.#addTimeZoneBtn = document.querySelector("#iucp-add-time-zone-button");
    this.#deleteTimeZoneBtn = document.querySelector("#iucp-delete-time-zone-button");
  }
  addTimeZone() {
    const markup = this.#timeZonesContainer.querySelector(".iucp-time-zone-container").cloneNode(true);
    markup.value = "";
    this.#timeZonesContainer.append(markup);
    this.#timeZonesContainer.insertAdjacentHTML("beforeend", "<br>");
    markup.querySelectorAll(".iucp-time-zone-input").forEach(element => {
      element.setAttribute("min", 0);
      element.setAttribute("max", 0);
      element.addEventListener("input", () => this.timeChanged(element));
    });
  }
  deleteTimeZone(target) {
    target.closest(".iucp-time-zone-container").remove();
  }
}
/* harmony default export */ __webpack_exports__["default"] = (new CartManager());
/******/ })()
;
//# sourceMappingURL=cart-manager.js.map