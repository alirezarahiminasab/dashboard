// import SwiperCore, { Navigation } from "swiper/modules";

// SwiperCore.use([Navigation]);

import React, { useRef, useState } from "react";
// Import Swiper React components
import { Swiper, SwiperSlide } from "swiper/react";

// Import Swiper styles
import "swiper/css";
import "swiper/css/pagination";

// // import required modules
// import { Navigation, Pagination } from "swiper/modules";

import { filterFields, filterFields3 } from "../data/tableData";
import FilterButtons from "./FilterButtons";
import { FaRegCircleDot } from "react-icons/fa6";
import { MdKeyboardArrowLeft, MdKeyboardArrowRight } from "react-icons/md";

export default function ProfileCard() {
  return (
    <div className="profile">
      <Filter />
      <Card />
      <Calender />
    </div>
  );
}

function Filter() {
  return (
    <div className="filter">
      <FilterButtons
        urlParamName="profile-btn"
        filterFields={filterFields3}
        numButtons={2}
      />
    </div>
  );
}

function Card() {
  return (
    <div>
      <div className="image-container">
        <img src="profile-image2.png" className="image" />
        <div className="label">
          <div>
            <h1>Martha Smith</h1>
            <h2>65yrs old - Male</h2>
          </div>
          <img className="call-icon" src="call-icon.png" />
        </div>
      </div>
      <div className="under-image">
        <h3>7246, Woodland Rd. Waukesha, WI 53186</h3>
        <h3>Cell +1 310-351-7774</h3>
        <h3>Last Appointment : 24 Jan, 2024</h3>
      </div>
    </div>
  );
}

function Calender() {
  const swiperRef = useRef(null);

  // Function to navigate to the previous slide
  const goToPrevSlide = () => {
    if (swiperRef.current) {
      swiperRef.current.swiper.slidePrev();
    }
  };

  // Function to navigate to the next slide
  const goToNextSlide = () => {
    if (swiperRef.current) {
      swiperRef.current.swiper.slideNext();
    }
  };

  return (
    <div className="calender">
      <div className="title">
        <h1>Appointments</h1>
        <div className="btns">
          <button onClick={goToPrevSlide}>
            <MdKeyboardArrowLeft />
          </button>
          <button onClick={goToNextSlide}>
            <MdKeyboardArrowRight />
          </button>
        </div>
      </div>
      <div className="date-slider">
        <Swiper slidesPerView={4} spaceBetween={-7} ref={swiperRef}>
          <SwiperSlide>
            <DateCard index={-2} todo={"blue"} />
          </SwiperSlide>
          <SwiperSlide>
            <DateCard index={-1} />
          </SwiperSlide>
          <SwiperSlide>
            <DateCard index={0} />
          </SwiperSlide>
          <SwiperSlide>
            <DateCard index={1} todo={"green"} />
          </SwiperSlide>
          <SwiperSlide>
            <DateCard index={2} />
          </SwiperSlide>
          <SwiperSlide>
            <DateCard index={3} />
          </SwiperSlide>
          <SwiperSlide>
            <DateCard index={4} />
          </SwiperSlide>
        </Swiper>

        {/* <DateCard index={-2}  />
        <DateCard index={-1} />
        <DateCard index={0} />
        <DateCard index={1} todo={"green"} />
        <DateCard index={2} /> */}
      </div>
      <TodoItem
        name="Mohammad Taheri"
        job="Mentor"
        hour="17:00"
        color={"blue"}
      />
      <TodoItem
        name="Hossein Salehpour"
        job="Front-end Developer"
        hour="17:00"
        color={"green"}
      />{" "}
    </div>
  );
}

function TodoItem({ name, job, hour, color }) {
  return (
    <div className={"todo-item " + color}>
      <div className="left-side">
        <h1>{name}</h1>
        <h2>{job}</h2>
      </div>
      <p>{hour}</p>
    </div>
  );
}

function DateCard({ index = 0, todo }) {
  const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

  const today = new Date();
  const customDay = new Date();
  customDay.setDate(today.getDate() + index);

  const day = customDay.getDate();
  const inWeek = dayNames[customDay.getDay()];

  return (
    <div className={`date ${index === 0 && "active"}`}>
      <h1>{day}</h1>
      <h2>{inWeek}</h2>
      {todo && (
        <div className={"todo-icon " + todo}>
          <FaRegCircleDot />
        </div>
      )}
    </div>
  );
}
