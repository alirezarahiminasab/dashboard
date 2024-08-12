// import Swiper bundle with all modules installed
import Swiper from "swiper/bundle";

// import styles bundle
import "swiper/css/bundle";
(function ($) {
  const swiper = new Swiper(
    ".instructor-profile-courses-container-wrap.swiper-container",
    {
      // Swiper options
      breakpoints: {
        // when window width is >= 1024px
        1024: {
          slidesPerView: 4,
          spaceBetween: 24,
        },
      },
    },
  );

  $(`.instructor-profile-slider-button.slider-button-prev`).on("click", () => {
    swiper.slideNext(500, true);
  });
  $(`.instructor-profile-slider-button.slider-button-next`).on("click", () => {
    swiper.slidePrev(500, true);
  });
})(jQuery);
