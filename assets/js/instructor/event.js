import AWS from "aws-sdk";
import toast from "../toast";
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
import Swiper from "swiper";
import { Autoplay } from "swiper/modules";

// import "swiper/css";
console.log("js file");

// gsap.registerPlugin(ScrollTrigger);

(function ($) {
  "use strict";

  class EventStatus {
    constructor() {
      this.elements = {
        // eventPrompt: $(".instructor-dropdown-parent"),
        // eventSort: $(".instructor-events-sort"),
        // sortBtn: $(".instructor-events-sort-btn"),
        // sortCloseBtn: $(".sort-header-close"),
        // eventFilter: $(".instructor-events-filter"),
        // filterBtn: $(".instructor-events-filter-btn"),
        // buyNow: $(".buy-now-button"),
        // filterWrap: $(".instructor-events-filter-wrap"),
        // eventStatistics: $(".event-statistics"),
        // eventAction: $(".event-action-btn"),
      };
      console.log("constructor");

      this.getMyEventsAjax();
      // this.update(elements);
      // this.sortEvent(elements);
      // this.singleProductAddToCart();
      // this.lessonFunctions();
    }

    getMyEventsAjax() {
      // select a tag in parent with class instructor-events-wrap-empty amd when clicked do
      $(".instructor-events-wrap-empty").on("click", () => {
        console.log("getMyEventsAjax");
        $.ajax({
          url: ajax_object.ajax_url,
          type: "GET",
          data: {
            action: "get_my_events",
          },
          beforeSend() {},
          success: function (response) {
            console.log(response);
          },
          error: function (response) {
            console.error(response);
          },
        });
      });
    }

    // update($el) {
    //   const plugin = this;

    //   $el.eventPrompt.on(
    //     "click",
    //     ".instructor-dropdown-parent-icon",
    //     function (e) {
    //       e.preventDefault();
    //       const dropdownMenu = $(this).siblings(
    //         ".instructor-dropdown-parent-menu"
    //       );

    //       if (dropdownMenu.css("display") === "none") {
    //         dropdownMenu.css("display", "flex");
    //       } else {
    //         dropdownMenu.css("display", "none");
    //       }
    //     }
    //   );

    //   $el.eventPrompt.on(
    //     "click",
    //     ".instructor-dropdown-item-status",
    //     function (e) {
    //       e.preventDefault();
    //       const hiddenEventInput = $(this).siblings("input");
    //       const eventAction = $(this).data("event-action");
    //       const eventID = $(this).data("event-id");

    //       const ajaxCall = $.ajax({
    //         url: ajax_object.ajax_url,
    //         type: "POST",
    //         data: {
    //           action: "change_event_status",
    //           eventAction: eventAction,
    //           eventID: eventID,
    //         },
    //         success: (response) => {
    //           // Handle successful upload
    //           toast(response.result, "success");
    //           if (hiddenEventInput.prop("checked") === true) {
    //             $(this).siblings("input").prop("checked", false);
    //           } else {
    //             $(this).siblings("input").prop("checked", true);
    //           }
    //         },
    //         error: (e) => {
    //           // Handle error
    //           console.log(e);
    //         },
    //       });
    //     }
    //   );

    //   $el.sortBtn.on("click", function (e) {
    //     e.preventDefault();
    //     $(".instructor-events-sort").show();
    //     gsap.to($(".instructor-events-sort-wrap"), {
    //       y: 0,
    //       duration: 0.3,
    //     });
    //   });

    //   $el.eventSort
    //     .find(".sort-header-close")
    //     .add($el.eventSort.find(".instructor-events-sort-bg"))
    //     .off("click")
    //     .on("click", function (e) {
    //       e.preventDefault();
    //       const tl = gsap.timeline();
    //       tl.to($(".instructor-events-sort-wrap"), {
    //         y: "100%",
    //         duration: 0.3,
    //       });
    //       tl.to($(".instructor-events-sort"), {
    //         display: "none",
    //       });
    //     });

    //   $el.eventSort
    //     .find(".instructor-events-sort-radio")
    //     .off("click")
    //     .on("click", function (e) {
    //       const authorID = $(this).data("author-id");
    //       const sort = $(this).data("sort");
    //       const tl = gsap.timeline();

    //       const ajaxCall = $.ajax({
    //         url: ajax_object.ajax_url,
    //         type: "POST",
    //         data: {
    //           action: "event_sort",
    //           authorID: authorID,
    //           sort: sort,
    //         },
    //         success: (response) => {
    //           // Handle successful upload
    //           $(".instructor-events-wrap-boxes").html(`${response.result}`);
    //           plugin.init();
    //         },
    //         error: (e) => {
    //           // Handle error
    //           console.log(e);
    //         },
    //       });
    //     });

    //   $el.filterBtn.on("click", function (e) {
    //     e.preventDefault();
    //     const tl = gsap.timeline();
    //     tl.to($(".instructor-events-filter"), {
    //       display: "block",
    //     });
    //     tl.to($(".instructor-events-filter"), {
    //       y: 0,
    //       duration: 0.3,
    //     });
    //   });

    //   $el.eventFilter.on("click", ".sort-header-close", function (e) {
    //     e.preventDefault();
    //     const tl = gsap.timeline();
    //     tl.to($(".instructor-events-filter"), {
    //       y: "100%",
    //       duration: 0.3,
    //     });
    //     tl.to($(".instructor-events-filter"), {
    //       display: "none",
    //     });
    //   });

    //   $el.eventFilter.on(
    //     "click",
    //     ".filter-wrap-setting-content-all",
    //     function (e) {
    //       const inputBoxes = $(this).parent().parent().find("input");

    //       if ($(this).prop("checked") === true) {
    //         inputBoxes.prop("checked", true);
    //       } else {
    //         inputBoxes.prop("checked", false);
    //       }
    //     }
    //   );

    //   $el.eventFilter.on(
    //     "click",
    //     ".filter-wrap-setting-content input:not(filter-wrap-setting-content-all)",
    //     function (e) {
    //       const inputBoxes = $(this)
    //         .parent()
    //         .parent()
    //         .find(".filter-wrap-setting-content-all");

    //       if ($(this).prop("checked") === false) {
    //         inputBoxes.prop("checked", false);
    //       }
    //     }
    //   );

    //   $el.eventFilter.on(
    //     "click",
    //     ".instructor-events-filter-buttons-show",
    //     function (e) {
    //       e.preventDefault();
    //       const tl = gsap.timeline();
    //       const instructor = $(this).data("instructor");
    //       const status = [];
    //       const category = [];

    //       $(
    //         ".instructor-events-filter .filter-wrap-setting-content-status:checked"
    //       ).each((index, el) => {
    //         status.push($(el).val());
    //       });

    //       $(
    //         ".instructor-events-filter .filter-wrap-setting-content-category:checked"
    //       ).each((index, el) => {
    //         category.push($(el).data("id"));
    //       });

    //       $.ajax({
    //         url: ajax_object.ajax_url,
    //         type: "POST",
    //         data: {
    //           action: "event_filter",
    //           status: status,
    //           category: category,
    //           instructor: instructor,
    //         },
    //         success: (response) => {
    //           tl.to($(".instructor-events-filter"), {
    //             y: "100%",
    //             duration: 0.3,
    //           });
    //           tl.to($(".instructor-events-filter"), {
    //             display: "none",
    //           });
    //           $(".instructor-events-wrap-boxes").html(`${response.result}`);
    //           plugin.init();
    //         },
    //         error: (e) => {
    //           // Handle error
    //           console.log(e);
    //         },
    //       });
    //     }
    //   );

    //   $el.eventFilter.on(
    //     "click",
    //     ".instructor-events-filter-buttons-reset",
    //     function (e) {
    //       e.preventDefault();
    //       const tl = gsap.timeline();
    //       const instructor = $(this).data("instructor");
    //       const status = ["publish", "pending", "trash"];

    //       $(".instructor-events-filter-wrap input:checkbox").prop(
    //         "checked",
    //         false
    //       );

    //       $.ajax({
    //         url: ajax_object.ajax_url,
    //         type: "POST",
    //         data: {
    //           action: "event_filter",
    //           status: status,
    //           category: "",
    //           instructor: instructor,
    //         },
    //         success: (response) => {
    //           tl.to($(".instructor-events-filter"), {
    //             y: "100%",
    //             duration: 0.3,
    //           });
    //           tl.to($(".instructor-events-filter"), {
    //             display: "none",
    //           });
    //           $(".instructor-events-wrap-boxes").html(`${response.result}`);
    //           plugin.init();
    //         },
    //         error: (e) => {
    //           // Handle error
    //           console.log(e);
    //         },
    //       });
    //     }
    //   );

    //   ScrollTrigger.create({
    //     trigger: ".footer-wrapper",
    //     start: "top-=59px bottom",
    //     onEnter: function () {
    //       // Change the position to relative when entering the trigger
    //       $el.eventAction.addClass("inline-button").removeClass("float-button");
    //     },
    //     onLeaveBack: function () {
    //       // Revert the position back to fixed when scrolling back up
    //       $el.eventAction.addClass("float-button").removeClass("inline-button");
    //     },
    //   });
    // }

    // sortEvent($el) {
    //   $el.eventStatistics
    //     .find(".event-statistics-sort-btn")
    //     .on("click", function (e) {
    //       e.preventDefault();
    //       $(".event-statistics-sort").show();
    //       gsap.to($(".event-statistics-sort-wrap"), {
    //         y: 0,
    //         duration: 0.3,
    //       });
    //     });

    //   $el.eventStatistics
    //     .find(".sort-header-close")
    //     .add($el.eventStatistics.find(".event-statistics-sort-bg"))
    //     .on("click", function (e) {
    //       e.preventDefault();
    //       const tl = gsap.timeline();
    //       tl.to($(".event-statistics-sort-wrap"), {
    //         y: "100%",
    //         duration: 0.3,
    //       });
    //       tl.to($(".event-statistics-sort"), {
    //         display: "none",
    //       });
    //     });

    //   $el.eventStatistics
    //     .find(".event-statistics-sort-radio")
    //     .on("click", function (e) {
    //       const sortType = $(this).data("sort"); // Get the sort type from data-sort attribute of clicked radio button

    //       // Select and sort the div elements based on data attribute specified by sortType
    //       const sortedElements = $el.eventStatistics
    //         .find(".event-statistics-footer-item")
    //         .sort(function (a, b) {
    //           // Convert data values to integers if they are numeric and compare for descending order
    //           return (
    //             parseInt($(b).data(sortType)) - parseInt($(a).data(sortType))
    //           );
    //         });

    //       // Select the container that wraps the items to be sorted
    //       const container = $(".event-statistics-footer-wrap");
    //       container.empty(); // Clear existing content in the container

    //       // Append sorted elements back to the container
    //       sortedElements.each(function () {
    //         container.append(this);
    //       });

    //       const tl = gsap.timeline();
    //       tl.to($(".event-statistics-sort-wrap"), {
    //         y: "100%",
    //         duration: 0.3,
    //       });
    //       tl.to($(".event-statistics-sort"), {
    //         display: "none",
    //       });
    //     });
    // }

    // singleProductAddToCart() {
    //   // wc_add_to_cart_params is required to continue, ensure the object exists.
    //   if (typeof wc_add_to_cart_params === "undefined") {
    //     return false;
    //   }

    //   // Ajax add to cart.
    //   $(document).on("click", ".buy-now-button-add-to-cart", function (evt) {
    //     var $thisButton = $(this);
    //     // Do nothing if this is external product.
    //     evt.preventDefault();

    //     if ($thisButton.hasClass("disabled")) {
    //       // Variation select required.
    //       return false;
    //     }

    //     if ($thisButton.hasClass("woosb-disabled")) {
    //       // Smart Bundle select required.
    //       return false;
    //     }

    //     var $variation_form = $(this).closest("form.buy-now");
    //     var var_id = $variation_form.find("input[name=variation_id]").val();
    //     var product_id = $variation_form.find("input[name=product_id]").val();
    //     var cartUrl = $variation_form.find("input[name=cart_url]").val();
    //     var quantity = $variation_form.find("input[name=quantity]").val();

    //     if ("add-to-cart" === $thisButton.attr("name")) {
    //       product_id = $thisButton.val();
    //     }

    //     $thisButton
    //       .removeClass("buy-now-button-add-to-cart")
    //       .append("<span class='loader'></span>");

    //     var data = {
    //       action: "add_to_cart",
    //       product_id: product_id,
    //     };

    //     $variation_form.serializeArray().map(function (attr) {
    //       if (attr.name !== "add-to-cart") {
    //         if (attr.name.endsWith("[]")) {
    //           let name = attr.name.substring(0, attr.name.length - 2);
    //           if (!(name in data)) {
    //             data[name] = [];
    //           }
    //           data[name].push(attr.value);
    //         } else {
    //           data[attr.name] = attr.value;
    //         }
    //       }
    //     });

    //     // Trigger event.
    //     $("body").trigger("adding_to_cart", [$thisButton, data]);

    //     // Ajax action.
    //     $.post(wc_add_to_cart_params.ajax_url, data, function (response) {
    //       if (!response) {
    //         return;
    //       }

    //       if (response.error && response.product_url) {
    //         window.location = response.product_url;
    //         return;
    //       }

    //       // Redirect to cart option
    //       if (wc_add_to_cart_params.cart_redirect_after_add === "yes") {
    //         window.location = wc_add_to_cart_params.cart_url;
    //         return;
    //       }

    //       $thisButton.text("مشاهده سبد خرید");
    //       $thisButton.attr("href", cartUrl);
    //       // Trigger event so themes can refresh other areas.
    //     }).always(function () {
    //       $thisButton.addClass("added").removeClass("loading updating-icon");
    //     });

    //     return false;
    //   });
    // }

    // lessonFunctions() {
    //   const swiperConfig = {
    //     loop: true,
    //     modules: [Autoplay],

    //     // autoplay: {
    //     //   delay: 3000,
    //     // },
    //   };

    //   const swiper = new Swiper(".single-lesson-related-slider", swiperConfig);

    //   $(".single-lesson-related-navigation")
    //     .find(".btn-right")
    //     .on("click", function (e) {
    //       e.preventDefault();
    //       swiper.slidePrev();
    //     });

    //   $(".single-lesson-related-navigation")
    //     .find(".btn-left")
    //     .on("click", function (e) {
    //       e.preventDefault();
    //       swiper.slideNext();
    //     });
    // }
  }
  const EventStatusInit = new EventStatus();
})(jQuery);
