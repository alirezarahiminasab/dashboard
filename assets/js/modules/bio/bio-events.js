import $ from "jquery";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

export default function initSlider() {
  //   Initialize Swiper when the document is ready
  const swiper = new Swiper(
    `.bio-reviews-slider-wrap .tutor-instructor-reviews-list .swiper-container`,
    {
      slidesPerView: 1,
      loop: true,
    }
  );
  $(`.bio-reviews-slider-wrap .slider-button-prev`).on("click", () => {
    swiper.slideNext(500, true);
  });
  $(`.bio-reviews-slider-wrap .slider-button-next`).on("click", () => {
    swiper.slidePrev(500, true);
  });
}

// Call the initSlider function when the document is ready
$(function () {
  initSlider();
});
