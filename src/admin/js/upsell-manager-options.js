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
  colorPickerInput.type =
    colorPickerInput.type === "checkbox" ? "color" : "checkbox";
}
