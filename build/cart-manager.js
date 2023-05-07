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
  #days;
  #markup;
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
    const parent = element.closest(".iucp-time-zone-container");
    const startTime = parent.querySelector("#start-time");
    const endTime = parent.querySelector("#end-time");
    const days = parent.querySelectorAll(".iucp_day_of_week");

    // update time logic
    element.setAttribute("value", element.value);
    startTime.setAttribute("name", `iucp_cart_manager_options[iucp_cart_time_zones][${startTime.value}]`);
    endTime.setAttribute("name", `iucp_cart_manager_options[iucp_cart_time_zones][${startTime.value}][end_time]`);
    startTime.setAttribute("max", endTime.value);
    startTime.setAttribute("min", 0);
    endTime.setAttribute("min", startTime.value);
    endTime.setAttribute("max", endTime.value);

    // update days time
    days.forEach((element, idx) => {
      element.setAttribute("name", `iucp_cart_manager_options[iucp_cart_time_zones][${startTime.value}][days][${this.#days[idx]}]`);
    });
  }
  initializeVariables() {
    this.#timeZonesContainer = document.querySelector("#iucp_cart_time_zones");
    this.#timeZonesInputs = this.#timeZonesContainer.querySelectorAll(".iucp-time-zone-input");
    this.#addTimeZoneBtn = document.querySelector("#iucp-add-time-zone-button");
    this.#deleteTimeZoneBtn = document.querySelector("#iucp-delete-time-zone-button");
    this.#days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
  }
  addTimeZone() {
    const markup = this.#timeZonesContainer.querySelector(".iucp-time-zone-container").cloneNode(true);
    markup.insertAdjacentHTML("beforeend", `
      <input type="submit" name="button" id="iucp-delete-time-zone-button" class="button delete iucp-flex" value="DELETE" style="margin-top: auto;">
    <br>`);
    markup.value = "";
    this.#timeZonesContainer.append(markup);
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