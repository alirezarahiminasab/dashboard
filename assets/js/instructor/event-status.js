import toast from "../toast";
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

(function ($) {
  "use strict";

  class EventStatus {
    constructor() {
      this.eventPrompt = $(".event-status-dropdown-parent");
      this.filterBtn = $(".event-status-filter-btn");
      this.eventFilter = $(".event-status-filter");
      this.eventAction = $(".event-action-btn");

      // this.transferData();
      this.init();
    }

    // transferData() {
    //   const scriptTag = document.getElementById("event-status-temp-data");
    //   this.data = JSON.parse(scriptTag.textContent).data.events;
    //   scriptTag.remove();
    //   // console.log(this.data);
    // }

    init() {
      // Toggle dropdown menu, for edit or delete event
      this.eventPrompt.on(
        "click",
        ".event-status-dropdown-parent-icon",
        function (e) {
          e.preventDefault();
          console.log("drop");
          const dropdownMenu = $(this).siblings(
            ".event-status-dropdown-parent-menu"
          );

          if (dropdownMenu.css("display") === "none") {
            dropdownMenu.css("display", "flex");
          } else {
            dropdownMenu.css("display", "none");
          }
        }
      );

      // delete an event
      this.eventPrompt.on(
        "click",
        ".event-status-dropdown-item-delete",
        function (e) {
          e.preventDefault();
          const $this = $(this); // Reference to the clicked delete button
          const eventID = $(this).data("event-id");

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
              action: "delete_event",
              eventID: eventID,
            },
            success: (response) => {
              if (response.success === true) {
                toast("رویداد با موفقیت حذف شد", "success");
                $this.closest(".event-status-wrap-boxes-event").remove();
              }
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        }
      );

      // open the filter list
      this.filterBtn.on("click", function (e) {
        e.preventDefault();
        const tl = gsap.timeline();
        tl.to($(".event-status-filter"), {
          display: "block",
        });
        tl.to($(".event-status-filter"), {
          y: 0,
          duration: 0.3,
        });
      });

      // close the filter list
      this.eventFilter.on(
        "click",
        ".event-status-sort-header-close",
        function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          tl.to($(".event-status-filter"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($(".event-status-filter"), {
            display: "none",
          });
        }
      );

      // handle btn-all action in form
      this.eventFilter.on(
        "click",
        ".filter-wrap-setting-content-all",
        function (e) {
          const inputBoxes = $(this).parent().parent().find("input");

          if ($(this).prop("checked") === true) {
            inputBoxes.prop("checked", true);
          } else {
            inputBoxes.prop("checked", false);
          }
        }
      );

      // handle btn-all action in form (if any checkboxes become disable)
      this.eventFilter.on(
        "click",
        ".filter-wrap-setting-content input:not(filter-wrap-setting-content-all)",
        function (e) {
          const inputBoxes = $(this)
            .parent()
            .parent()
            .find(".filter-wrap-setting-content-all");

          if ($(this).prop("checked") === false) {
            inputBoxes.prop("checked", false);
          }
        }
      );

      this.eventFilter.on("click", ".event-status-filter-buttons-show", (e) => {
        e.preventDefault();

        // Gather selected filter criteria
        const selectedStatuses = [];
        const selectedCategories = [];

        // Get all selected status checkboxes
        $(
          ".event-status-filter .filter-wrap-setting-content-status:checked"
        ).each((index, el) => {
          selectedStatuses.push($(el).val());
        });

        // Get all selected category checkboxes
        $(
          ".event-status-filter .filter-wrap-setting-content-category:checked"
        ).each((index, el) => {
          selectedCategories.push($(el).data("id"));
        });

        // Perform filtering based on selected criteria
        this.filterEvents(selectedStatuses, selectedCategories);
      });

      this.eventFilter.on(
        "click",
        ".event-status-filter-buttons-reset",
        (e) => {
          e.preventDefault();
          $(".event-status-filter input:checkbox").prop("checked", false);
          $(".event-status-wrap-boxes-event").show();
          const tl = gsap.timeline();
          tl.to(this.eventFilter, {
            y: "100%",
            duration: 0.3,
          });
          tl.to(this.eventFilter, {
            display: "none",
          });
        }
      );

      // ScrollTrigger.create({
      //   trigger: ".footer-wrapper",
      //   start: "top-=59px bottom",
      //   onEnter: function () {
      //     // Change the position to relative when entering the trigger
      //     this.eventAction
      //       .addClass("inline-button")
      //       .removeClass("float-button");
      //   },
      //   onLeaveBack: function () {
      //     // Revert the position back to fixed when scrolling back up
      //     this.eventAction
      //       .addClass("float-button")
      //       .removeClass("inline-button");
      //   },
      // });
    }

    filterEvents(selectedStatuses, selectedCategories) {
      // Loop through all events and decide whether to show or hide each card
      $(".event-status-wrap-boxes-event").each((index, element) => {
        const $eventCard = $(element);

        // Get event status and category from data attributes or your event data structure
        const eventStatus = $eventCard
          .find(".event-status-metadata-status p")
          .attr("class")
          .replace("event-status-", "");
        const eventCategory = $eventCard
          .find(".event-status-metadata-category p")
          .text()
          .trim();

        // Determine if the card should be shown
        const statusMatches =
          selectedStatuses.length === 0 ||
          selectedStatuses.includes(eventStatus);
        const categoryMatches =
          selectedCategories.length === 0 ||
          selectedCategories.includes(eventCategory);

        if (statusMatches && categoryMatches) {
          $eventCard.show(); // Show the card if it matches the filter criteria
        } else {
          $eventCard.hide(); // Hide the card if it doesn't match
        }
      });

      // Hide the filter UI
      const tl = gsap.timeline();
      tl.to(this.eventFilter, {
        y: "100%",
        duration: 0.3,
      });
      tl.to(this.eventFilter, {
        display: "none",
      });
    }
  }

  new EventStatus();
})(jQuery);
