import gsap from "gsap";

const bio_section = document.querySelector(".tutor-courses-events");
const see_more = document.querySelector(".tutor-courses-events .see-more");

const tl = gsap.timeline();

if (see_more) {
  see_more.addEventListener("click", (e) => {
    e.preventDefault();
    tl.to(bio_section, {
      marginTop: "0",
    });

    tl.to(see_more, {
      display: "none",
    });
  });
}
