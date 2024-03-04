import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";

export default function Slider() {
  return (
    <Swiper slidesPerView={"auto"} spaceBetween={5} className="mySwiper">
      <SwiperSlide className="slide active">Slideeeeeeeee 1</SwiperSlide>
      <SwiperSlide className="slide">Slide 2</SwiperSlide>
      <SwiperSlide className="slide">Slide 3</SwiperSlide>
      <SwiperSlide className="slide">Slideeee 4</SwiperSlide>
      <SwiperSlide className="slide">Sliiiiiide 5</SwiperSlide>
      <SwiperSlide className="slide">Slide 6</SwiperSlide>
      <SwiperSlide className="slide">Slllllide 7</SwiperSlide>
      <SwiperSlide className="slide">Slide 8</SwiperSlide>
      <SwiperSlide className="slide">SSSSSSSSSSlide 9</SwiperSlide>
    </Swiper>
  );
}

// .swiper {
//   @apply border-r-2 border-gray-200;
//   // box-shadow: 15px 0 10px rgba(0, 0, 0, 0.5);

//   .slide {
//     @apply inline-block w-auto rounded-3xl py-2 px-4 border-2 border-gray-200 cursor-pointer;

//     &.active {
//       @apply bg-gray-950 text-gray-100;
//     }
//   }
// }
