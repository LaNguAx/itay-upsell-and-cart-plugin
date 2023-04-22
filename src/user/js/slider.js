import $ from "jquery";
window.addEventListener("DOMContentLoaded", function (e) {
  $(function () {
    const slider = document.getElementsByClassName("slider").item(0);

    let isDrag = false,
      startPos = 0,
      curIndex = 0,
      curTranslate = 0,
      preTranslate = 0,
      animationId = null;

    $(".slider-item").on("mousedown mousemove mouseup mouseleave", (e) => {
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
      return event.type.includes("mouse")
        ? event.pageX
        : event.touches[0].clientX;
    }
    function animation() {
      if (isDrag) requestAnimationFrame(animation);
      setSliderPosition();
    }
    function startSlide(event) {
      startPos = getPositionX(event);
      isDrag = true;
      animationId = requestAnimationFrame(animation);
      $(".slider").removeClass("animation").css("cursor", "grabbing");
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
      if (Moved < -100 && curIndex < $(".slider-item").length - 1 - 2)
        curIndex++;
      if (Moved > 100 && curIndex > 0) curIndex--;
      setPositionByIndex();
      $(".slider").addClass("animation").css("cursor", "grab");
    }
    function setPositionByIndex() {
      curTranslate = ($(".slider-item").width() + 40) * curIndex * -1;
      preTranslate = curTranslate;
      setSliderPosition();
    }
    function setSliderPosition() {
      $(".slider-container .slider").css(
        "transform",
        `translateX(${curTranslate}px)`
      );
    }
    $(".btn-right").click(() => {
      curIndex =
        ++curIndex < $(".slider-item").length - 1 - 2
          ? curIndex
          : $(".slider-item").length - 1 - 2;
      endSlide();
    });
    $(".btn-left").click(() => {
      curIndex = --curIndex > 0 ? curIndex : 0;
      endSlide();
    });
  });

  window.addEventListener("hashchange", function (e) {
    const newHash = window.location.hash;
    const overlay = document.querySelector(".upsell-overlay");
    const slider = document.querySelector(
      `.${newHash.slice(1)}.subslider.hidden`
    );
    slider.classList.remove("hidden");

    document.body.style.height = "100%";
    document.body.style.overflow = "hidden";
  });
});
