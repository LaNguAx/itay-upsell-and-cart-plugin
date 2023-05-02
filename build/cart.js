/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./src/user/js/cart.js ***!
  \*****************************/
class Cart {
  #form;
  #datePicker;
  #timePicker;
  #userTime;
  #siteTimes;
  #todaySelected;
  #instantiated;
  #data = {
    date: undefined,
    time: undefined
  };
  constructor() {
    jQuery(document).ajaxStop(() => {
      if (this.#instantiated) return;
      this.#instantiated = true;
      this.initializeVariables();
      console.log("hello");
      this.events();
    });
  }
  events() {
    // form submit
    this.#form.on("submit", e => {
      e.preventDefault();
      this.submitForm();
    });

    // Date change
    this.#datePicker.datepicker("option", "onSelect", function (dateText, inst) {
      // update the date property.
      this.#data.date = new Date(dateText).getDate();
      const currentDate = new Date().getDate();
      this.#todaySelected = this.#data.date == currentDate ? true : false;
      console.log(this.#todaySelected);
      // show time selector.
      this.showTimeSelector();
    }.bind(this));

    //Time selected
    this.#timePicker.change(function () {
      alert("changed");
    });
  }
  showTimeSelector() {
    if (this.#timePicker.hasClass("hidden")) {
      this.#form.find("#arrival-time-label").removeClass("hidden");
      this.#timePicker.removeClass("hidden");
    }
    this.generateTimes();
  }
  generateTimes() {
    this.#userTime = new Date().toLocaleTimeString("he-IL", {
      hour12: false,
      hour: "2-digit",
      minute: "2-digit"
    });
    this.#timePicker[0].innerHTML = "";
    for (const [start, end] of Object.entries(this.#siteTimes)) {
      if (this.#todaySelected) {
        if (this.#userTime < start) {
          this.#timePicker[0].innerHTML += `<option>${start}:${end}</option>`;
        }
      } else {
        this.#timePicker[0].innerHTML += `<option>${start}:${end}</option>`;
      }
    }
  }
  submitForm() {
    //rendering a spinner
    const url = this.#form.attr("data-url");
    const data = {};
    const formData = [...new FormData(this.#form[0])];
    formData.forEach(element => {
      data[element[0]] = element[1];
    });
    console.log(data);
    this.renderSpinner();
    jQuery.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: "json",
      success: function (data, textStatus, jqXHR) {
        //process data
        console.log(data);
        this.showCart();
      }.bind(this),
      error: function (data, textStatus, jqXHR) {
        //process error msg
        console.log(data);
      }
    });
  }
  showCart() {
    jQuery(".iucp-address-container, .xoo-wsc-body, .xoo-wsc-footer").each(function () {
      jQuery(this).toggleClass("hidden");
    });
  }
  renderSpinner() {
    this.#form[0].innerHTML = "<div class='lds-dual-ring'></div>";
  }
  initializeVariables() {
    this.#siteTimes = iucpTimes;
    this.#form = jQuery("#iucp_form");
    this.#datePicker = jQuery("#iucp_datepicker").datepicker({
      dateFormat: "mm-dd-yy",
      minDate: 0,
      beforeShowDay: date => {
        return [date.getDay() == 0 || date.getDay() == 1 || date.getDay() == 2 || date.getDay() == 3 || date.getDay() == 4 || date.getDay() == 5];
      }
    });
    this.#timePicker = jQuery("#iucp_address_arrival_time");
  }
}
const iucpCart = new Cart();
/******/ })()
;
//# sourceMappingURL=cart.js.map