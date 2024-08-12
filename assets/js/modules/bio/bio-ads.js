import $ from "jquery";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

export default function initSlider() {
  //   Initialize Swiper when the document is ready
  const swiper = new Swiper(`.bio-ads-wrap .ads-slider`, {
    spaceBetween: 8,
    centeredSlides: true,
    slidesPerView: 1.4,
    // If we need pagination
    pagination: {
      el: ".bio-ads-wrap .ads-slider .swiper-pagination",
    },
  });
  $(`.bio-ads-wrap .ads-button-prev`).on("click", () => {
    swiper.slidePrev(500, true);
  });
  $(`.bio-ads-wrap .ads-button-next`).on("click", () => {
    swiper.slideNext(500, true);
  });
}

// Call the initSlider function when the document is ready
$(function () {
  initSlider();
});
