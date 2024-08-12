import gsap from "gsap";

(function ($) {
  "use strict";

  class DisplayCourse {
    constructor() {
      this.topicsHandler();
    }

    topicsHandler = () => {
      $(document).on(
        "click",
        ".single-course-topics-contents-item-title",
        function () {
          $(this).parent().toggleClass("topic-active");
        },
      );
    };
  }

  const displayCourse = new DisplayCourse();
})(jQuery);
