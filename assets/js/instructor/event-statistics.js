import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

(function ($) {
  "use strict";

  const EventStatistics = function () {
    this.init = function () {
      const elements = {
        eventStatistics: $(".event-statistics"),
      };
      const plugin = this;

      plugin.sortEvent(elements);
    };

    this.sortEvent = function ($el) {
      $el.eventStatistics
        .find(".event-statistics-sort-btn")
        .on("click", function (e) {
          e.preventDefault();
          $(".event-statistics-sort").show();
          gsap.to($(".event-statistics-sort-wrap"), {
            y: 0,
            duration: 0.3,
          });
        });

      $el.eventStatistics
        .find(".sort-header-close")
        .add($el.eventStatistics.find(".event-statistics-sort-bg"))
        .on("click", function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          tl.to($(".event-statistics-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($(".event-statistics-sort"), {
            display: "none",
          });
        });

      $el.eventStatistics
        .find(".event-statistics-sort-radio")
        .on("click", function (e) {
          const sortType = $(this).data("sort"); // Get the sort type from data-sort attribute of clicked radio button

          const formData = new FormData();

          formData.append("action", "get_stats");
          formData.append("sort", sortType);

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function (response) {
              if (response.success) {
                $(".event-statistics-footer-wrap").html(response.data.html);
              } else {
                console.error("Error in response:", response);
              }
            },
            error: function (response) {
              console.error(response);
            },
          });
        });
    };
  };

  const EventStatisticsInit = new EventStatistics();
  EventStatisticsInit.init();
})(jQuery);
