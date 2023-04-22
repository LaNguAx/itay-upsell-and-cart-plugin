/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ (function(module) {

module.exports = window["jQuery"];

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
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!*******************************!*\
  !*** ./src/user/js/slider.js ***!
  \*******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

window.addEventListener("DOMContentLoaded", function (e) {
  jquery__WEBPACK_IMPORTED_MODULE_0___default()(function () {
    const slider = document.getElementsByClassName("slider").item(0);
    let isDrag = false,
      startPos = 0,
      curIndex = 0,
      curTranslate = 0,
      preTranslate = 0,
      animationId = null;
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider-item").on("mousedown mousemove mouseup mouseleave", e => {
      e.preventDefault();
    });
    slider.onmousedown = startSlide;
    slider.ontouchstart = startSlide;
    slider.onmousemove = moveSlide;
    slider.ontouchmove = moveSlide;
    slider.onmouseup = endSlide;
    slider.onmouseleave = endSlide;
    slider.ontouchend = endSlide;
    function getPositionX(event) {
      return event.type.includes("mouse") ? event.pageX : event.touches[0].clientX;
    }
    function animation() {
      if (isDrag) requestAnimationFrame(animation);
      setSliderPosition();
    }
    function startSlide(event) {
      startPos = getPositionX(event);
      isDrag = true;
      animationId = requestAnimationFrame(animation);
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider").removeClass("animation").css("cursor", "grabbing");
    }
    function moveSlide() {
      if (isDrag) {
        const positionX = getPositionX(event);
        curTranslate = preTranslate + positionX - startPos;
      }
    }
    function endSlide() {
      isDrag = false;
      cancelAnimationFrame(animation);
      const Moved = curTranslate - preTranslate;
      if (Moved < -100 && curIndex < jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider-item").length - 1 - 2) curIndex++;
      if (Moved > 100 && curIndex > 0) curIndex--;
      setPositionByIndex();
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider").addClass("animation").css("cursor", "grab");
    }
    function setPositionByIndex() {
      curTranslate = (jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider-item").width() + 40) * curIndex * -1;
      preTranslate = curTranslate;
      setSliderPosition();
    }
    function setSliderPosition() {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider-container .slider").css("transform", `translateX(${curTranslate}px)`);
    }
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(".btn-right").click(() => {
      curIndex = ++curIndex < jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider-item").length - 1 - 2 ? curIndex : jquery__WEBPACK_IMPORTED_MODULE_0___default()(".slider-item").length - 1 - 2;
      endSlide();
    });
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(".btn-left").click(() => {
      curIndex = --curIndex > 0 ? curIndex : 0;
      endSlide();
    });
  });
  window.addEventListener("hashchange", function (e) {
    const newHash = window.location.hash;
    const overlay = document.querySelector(".upsell-overlay");
    const slider = document.querySelector(`.${newHash.slice(1)}.subslider.hidden`);
    slider.classList.remove("hidden");
    document.body.style.height = "100%";
    document.body.style.overflow = "hidden";
  });
});
}();
/******/ })()
;
//# sourceMappingURL=slider.js.map