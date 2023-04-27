/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/admin/js/upsell-manager-options.js":
/*!************************************************!*\
  !*** ./src/admin/js/upsell-manager-options.js ***!
  \************************************************/
/***/ (function() {

window.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".wrap.upsell-manager-options");
  container.addEventListener("click", function (e) {
    const target = e.target.closest(".color-checkbox");
    if (!target) return;
    handleCheckboxClick(target);
  });
});
function handleCheckboxClick(target) {
  const parent = target.closest(".iucp-setting-container.color");
  const colorPicker = parent.querySelector(".color-picker-container");
  const checkbox = parent.querySelector(".color-checkbox");
  if (checkbox.classList.contains("always-on")) {
    checkbox.checked = true;
    return;
  }
  colorPicker.classList.toggle("hidden");
  const colorPickerInput = colorPicker.querySelector("input");
  colorPickerInput.type = colorPickerInput.type === "checkbox" ? "color" : "checkbox";
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!****************************************!*\
  !*** ./src/admin/js/upsell-manager.js ***!
  \****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _upsell_manager_options_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./upsell-manager-options.js */ "./src/admin/js/upsell-manager-options.js");
/* harmony import */ var _upsell_manager_options_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_upsell_manager_options_js__WEBPACK_IMPORTED_MODULE_0__);

window.addEventListener("DOMContentLoaded", () => {
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
    // Navigation tabs end

    // Validate checked inputs to send to db.
    const productsContainer = document.querySelector(".wrap.upsell-products-container");
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
  inputs.forEach(input => {
    input.type = input.type === "checkbox" ? "hidden" : "checkbox";
  });
}
}();
/******/ })()
;
//# sourceMappingURL=upsell-manager.js.map