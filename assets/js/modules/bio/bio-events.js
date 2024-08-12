import Swiper from "swiper/bundle";
import "swiper/css/bundle";

// Call the initSlider function when the document is ready
(function ($) {
  //   Initialize Swiper when the document is ready
  const swiper = new Swiper(
    `.bio-reviews-slider-wrap .tutor-instructor-reviews-list .swiper-container`,
    {
      slidesPerView: 1,
      loop: true,
      spaceBetween: 16,
      breakpoints: {
        // when window width is >= 1024px
        1024: {
          slidesPerView: 3,
          spaceBetween: 24,
        },
      },
    },
  );
  $(`.bio-reviews-slider-wrap .slider-button-prev`).on("click", () => {
    swiper.slideNext(500, true);
  });
  $(`.bio-reviews-slider-wrap .slider-button-next`).on("click", () => {
    swiper.slidePrev(500, true);
  });
})(jQuery);
