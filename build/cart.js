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
  #daySelected;
  #instantiated;
  #timeReducer = 1;
  #data = {
    date: undefined,
    time: undefined
  };
  constructor() {
    if (this.#instantiated) return;
    jQuery(document.body).on("wc_fragments_refreshed", () => {
      this.initializeVariables();
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
      const days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
      this.#daySelected = days[jQuery(this.#datePicker).datepicker("getDate").getDay()];

      // show time selector.
      this.showTimeSelector();
    }.bind(this));

    //Time selected -- irrelevant
    // this.#timePicker.change(function () {});
  }

  showTimeSelector() {
    if (this.#timePicker.hasClass("hidden")) {
      this.#form.find("#arrival-time-label").removeClass("hidden");
      this.#timePicker.removeClass("hidden");
    }
    this.generateTimes();
  }
  generateTimes() {
    this.#userTime = new Date().getTime();
    this.#timePicker[0].innerHTML = "";
    const newRestrictedTime = this.#userTime - this.#timeReducer * (3600 * 1000);
    const newUserTime = new Date(newRestrictedTime).toLocaleTimeString("he-IL", {
      hour12: false,
      hour: "2-digit",
      minute: "2-digit"
    });
    this.#userTime = newUserTime;
    console.log(this.#siteTimes);
    let foundTimeZones = 0;
    for (const [start, timeZoneData] of Object.entries(this.#siteTimes)) {
      if (this.#todaySelected) {
        if (this.#userTime < start) {
          this.#timePicker[0].innerHTML += `<option>${start}:${timeZoneData.end_time}</option>`;
        } else {
          this.#timePicker[0].innerHTML = `<option>Deliveries on ${this.#daySelected} are over.</option>`;
          return;
        }
      }
      if (timeZoneData.days[this.#daySelected]) {
        foundTimeZones++;
        this.#timePicker[0].innerHTML += `<option>${start}:${timeZoneData.end_time}</option>`;
      }
    }
    if (!foundTimeZones) this.#timePicker[0].innerHTML = `<option>We are not doing deliveries on ${this.#daySelected}</option>`;
  }
  submitForm() {
    //rendering a spinner
    const url = this.#form.attr("data-url");
    const data = {};
    const formData = [...new FormData(this.#form[0])];
    formData.forEach(element => {
      data[element[0]] = element[1];
    });
    this.renderSpinner();
    jQuery.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: "json",
      success: function (data, textStatus, jqXHR) {
        // Process successful response.
        this.showCart();
      }.bind(this),
      error: function (data, textStatus, jqXHR) {
        //Process error response.
        alert("An error has occured\nPlease reload the page.");
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
      firstDay: 0,
      beforeShowDay: date => {
        return [date.getDay() == 0 || date.getDay() == 1 || date.getDay() == 2 || date.getDay() == 3 || date.getDay() == 4 || date.getDay() == 5 || date.getDay() == 6];
      },
      beforeShow: function (input, inst) {
        const rect = input.getBoundingClientRect();
        // use 'setTimeout' to prevent effect overridden by other scripts
        setTimeout(function () {
          const scrollTop = jQuery("body").scrollTop();
          inst.dpDiv.css({
            top: rect.top + input.offsetHeight + scrollTop
          });
        }, 0);
      }
    });
    this.#timePicker = jQuery("#iucp_address_arrival_time");
  }
}

// Initialize the class.
const iucpCart = new Cart();
/******/ })()
;
//# sourceMappingURL=cart.js.map