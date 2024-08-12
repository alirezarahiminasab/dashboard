// Ensure GSAP and ScrollTrigger are loaded
import gsap from "gsap";
import { ScrollTrigger } from "gsap";

gsap.registerPlugin(ScrollTrigger);

(function ($) {
  "use strict";

  if (Boolean($(".single-course-action").length)) {
    // Get the height of the stop-div to use as an offset
    const stopDiv = $(".single-course-item:last");
    const stopDivTop =
      stopDiv[0].getBoundingClientRect().bottom + $(window).scrollTop();
    console.log(stopDivTop);

    // Animate the floating-div
    gsap.to(".single-course-action", {
      y: () => stopDivTop - $(".single-course-action").outerHeight() - 160, // Adjust outerHeight and margin as needed
      ease: "none",
      scrollTrigger: {
        trigger: ".single-course-wrap",
        start: "top top",
        end: () => `+=${stopDivTop - $(window).height() - 150}`,
        scrub: true,
      },
    });
  }
})(jQuery);
