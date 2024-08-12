import Swiper from "swiper/bundle";
import "swiper/css/bundle";

// Call the initSlider function when the document is ready
(function ($) {
  const swiper = new Swiper(`.single-course-others-wrap-slider`, {
    slidesPerView: 1,
    loop: true,
    breakpoints: {
      // when window width is >= 640px
      1024: {
        slidesPerView: 4,
        spaceBetween: 24,
      },
    },
  });
  $(`.single-course-others .slider-button-prev`).on("click", () => {
    swiper.slideNext(500, true);
  });
  $(`.single-course-others .slider-button-next`).on("click", () => {
    swiper.slidePrev(500, true);
  });
})(jQuery);
