import Swiper from "swiper/bundle";
import "swiper/css/bundle";

export default function initSlider() {
  //   Initialize Swiper when the document is ready
  const swiper = new Swiper(`.instructor-events .instructor-events-slider`, {
    slidesPerView: 1,
    loop: true,
  });
  $(`.instructor-events .slider-button-prev`).on("click", () => {
    swiper.slideNext(500, true);
  });
  $(`.instructor-events .slider-button-next`).on("click", () => {
    swiper.slidePrev(500, true);
  });
}

// Call the initSlider function when the document is ready
$(function () {
  initSlider();
})(jQuery);
