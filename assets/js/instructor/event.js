import AWS from "aws-sdk";
import toast from "../toast";
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
import Swiper from "swiper";
import { Autoplay } from "swiper/modules";

import "swiper/css";

gsap.registerPlugin(ScrollTrigger);

(function ($) {
  "use strict";

  const EdumallCourse = function () {
    this.init = function () {
      const elements = {
        coursePrompt: $(".instructor-dropdown-parent"),
        courseSort: $(".instructor-courses-sort"),
        sortBtn: $(".instructor-courses-sort-btn"),
        sortCloseBtn: $(".sort-header-close"),
        courseFilter: $(".instructor-courses-filter"),
        filterBtn: $(".instructor-courses-filter-btn"),
        buyNow: $(".buy-now-button"),
        filterWrap: $(".instructor-courses-filter-wrap"),
        courseStatistics: $(".course-statistics"),
        courseAction: $(".course-action-btn"),
      };
      const plugin = this;

      plugin.update(elements);
      plugin.sortCourse(elements);
      plugin.singleProductAddToCart();
      plugin.lessonFunctions();
    };

    this.update = function ($el) {
      const plugin = this;

      $el.coursePrompt.on(
        "click",
        ".instructor-dropdown-parent-icon",
        function (e) {
          e.preventDefault();
          console.log("drop");
          const dropdownMenu = $(this).siblings(
            ".instructor-dropdown-parent-menu"
          );

          if (dropdownMenu.css("display") === "none") {
            dropdownMenu.css("display", "flex");
          } else {
            dropdownMenu.css("display", "none");
          }
        }
      );

      $el.coursePrompt.on(
        "click",
        ".instructor-dropdown-item-status",
        function (e) {
          e.preventDefault();
          const hiddenCourseInput = $(this).siblings("input");
          const courseAction = $(this).data("course-action");
          const courseID = $(this).data("course-id");

          const ajaxCall = $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
              action: "change_course_status",
              courseAction: courseAction,
              courseID: courseID,
            },
            success: (response) => {
              // Handle successful upload
              toast(response.result, "success");
              if (hiddenCourseInput.prop("checked") === true) {
                $(this).siblings("input").prop("checked", false);
              } else {
                $(this).siblings("input").prop("checked", true);
              }
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        }
      );

      $el.sortBtn.on("click", function (e) {
        e.preventDefault();
        $(".instructor-courses-sort").show();
        gsap.to($(".instructor-courses-sort-wrap"), {
          y: 0,
          duration: 0.3,
        });
      });

      $el.courseSort
        .find(".sort-header-close")
        .add($el.courseSort.find(".instructor-courses-sort-bg"))
        .off("click")
        .on("click", function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          tl.to($(".instructor-courses-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($(".instructor-courses-sort"), {
            display: "none",
          });
        });

      $el.courseSort
        .find(".instructor-courses-sort-radio")
        .off("click")
        .on("click", function (e) {
          const authorID = $(this).data("author-id");
          const sort = $(this).data("sort");
          const tl = gsap.timeline();

          const ajaxCall = $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
              action: "course_sort",
              authorID: authorID,
              sort: sort,
            },
            success: (response) => {
              // Handle successful upload
              $(".instructor-courses-wrap-boxes").html(`${response.result}`);
              plugin.init();
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        });

      $el.filterBtn.on("click", function (e) {
        e.preventDefault();
        const tl = gsap.timeline();
        tl.to($(".instructor-courses-filter"), {
          display: "block",
        });
        tl.to($(".instructor-courses-filter"), {
          y: 0,
          duration: 0.3,
        });
      });

      $el.courseFilter.on("click", ".sort-header-close", function (e) {
        e.preventDefault();
        const tl = gsap.timeline();
        tl.to($(".instructor-courses-filter"), {
          y: "100%",
          duration: 0.3,
        });
        tl.to($(".instructor-courses-filter"), {
          display: "none",
        });
      });

      $el.courseFilter.on(
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

      $el.courseFilter.on(
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

      $el.courseFilter.on(
        "click",
        ".instructor-courses-filter-buttons-show",
        function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          const instructor = $(this).data("instructor");
          const status = [];
          const category = [];

          $(
            ".instructor-courses-filter .filter-wrap-setting-content-status:checked"
          ).each((index, el) => {
            status.push($(el).val());
          });

          $(
            ".instructor-courses-filter .filter-wrap-setting-content-category:checked"
          ).each((index, el) => {
            category.push($(el).data("id"));
          });

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
              action: "course_filter",
              status: status,
              category: category,
              instructor: instructor,
            },
            success: (response) => {
              tl.to($(".instructor-courses-filter"), {
                y: "100%",
                duration: 0.3,
              });
              tl.to($(".instructor-courses-filter"), {
                display: "none",
              });
              $(".instructor-courses-wrap-boxes").html(`${response.result}`);
              plugin.init();
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        }
      );

      $el.courseFilter.on(
        "click",
        ".instructor-courses-filter-buttons-reset",
        function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          const instructor = $(this).data("instructor");
          const status = ["publish", "pending", "trash"];

          $(".instructor-courses-filter-wrap input:checkbox").prop(
            "checked",
            false
          );

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
              action: "course_filter",
              status: status,
              category: "",
              instructor: instructor,
            },
            success: (response) => {
              tl.to($(".instructor-courses-filter"), {
                y: "100%",
                duration: 0.3,
              });
              tl.to($(".instructor-courses-filter"), {
                display: "none",
              });
              $(".instructor-courses-wrap-boxes").html(`${response.result}`);
              plugin.init();
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        }
      );

      ScrollTrigger.create({
        trigger: ".footer-wrapper",
        start: "top-=59px bottom",
        onEnter: function () {
          // Change the position to relative when entering the trigger
          $el.courseAction
            .addClass("inline-button")
            .removeClass("float-button");
        },
        onLeaveBack: function () {
          // Revert the position back to fixed when scrolling back up
          $el.courseAction
            .addClass("float-button")
            .removeClass("inline-button");
        },
      });
    };

    this.sortCourse = function ($el) {
      $el.courseStatistics
        .find(".course-statistics-sort-btn")
        .on("click", function (e) {
          e.preventDefault();
          $(".course-statistics-sort").show();
          gsap.to($(".course-statistics-sort-wrap"), {
            y: 0,
            duration: 0.3,
          });
        });

      $el.courseStatistics
        .find(".sort-header-close")
        .add($el.courseStatistics.find(".course-statistics-sort-bg"))
        .on("click", function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          tl.to($(".course-statistics-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($(".course-statistics-sort"), {
            display: "none",
          });
        });

      $el.courseStatistics
        .find(".course-statistics-sort-radio")
        .on("click", function (e) {
          const sortType = $(this).data("sort"); // Get the sort type from data-sort attribute of clicked radio button

          // Select and sort the div elements based on data attribute specified by sortType
          const sortedElements = $el.courseStatistics
            .find(".course-statistics-footer-item")
            .sort(function (a, b) {
              // Convert data values to integers if they are numeric and compare for descending order
              return (
                parseInt($(b).data(sortType)) - parseInt($(a).data(sortType))
              );
            });

          // Select the container that wraps the items to be sorted
          const container = $(".course-statistics-footer-wrap");
          container.empty(); // Clear existing content in the container

          // Append sorted elements back to the container
          sortedElements.each(function () {
            container.append(this);
          });

          const tl = gsap.timeline();
          tl.to($(".course-statistics-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($(".course-statistics-sort"), {
            display: "none",
          });
        });
    };

    this.singleProductAddToCart = function () {
      // wc_add_to_cart_params is required to continue, ensure the object exists.
      if (typeof wc_add_to_cart_params === "undefined") {
        return false;
      }

      // Ajax add to cart.
      $(document).on("click", ".buy-now-button-add-to-cart", function (evt) {
        var $thisButton = $(this);
        // Do nothing if this is external product.
        evt.preventDefault();

        if ($thisButton.hasClass("disabled")) {
          // Variation select required.
          return false;
        }

        if ($thisButton.hasClass("woosb-disabled")) {
          // Smart Bundle select required.
          return false;
        }

        var $variation_form = $(this).closest("form.buy-now");
        var var_id = $variation_form.find("input[name=variation_id]").val();
        var product_id = $variation_form.find("input[name=product_id]").val();
        var cartUrl = $variation_form.find("input[name=cart_url]").val();
        var quantity = $variation_form.find("input[name=quantity]").val();

        if ("add-to-cart" === $thisButton.attr("name")) {
          product_id = $thisButton.val();
        }

        $thisButton
          .removeClass("buy-now-button-add-to-cart")
          .append("<span class='loader'></span>");

        var data = {
          action: "add_to_cart",
          product_id: product_id,
        };

        $variation_form.serializeArray().map(function (attr) {
          if (attr.name !== "add-to-cart") {
            if (attr.name.endsWith("[]")) {
              let name = attr.name.substring(0, attr.name.length - 2);
              if (!(name in data)) {
                data[name] = [];
              }
              data[name].push(attr.value);
            } else {
              data[attr.name] = attr.value;
            }
          }
        });

        // Trigger event.
        $("body").trigger("adding_to_cart", [$thisButton, data]);

        // Ajax action.
        $.post(wc_add_to_cart_params.ajax_url, data, function (response) {
          if (!response) {
            return;
          }

          if (response.error && response.product_url) {
            window.location = response.product_url;
            return;
          }

          // Redirect to cart option
          if (wc_add_to_cart_params.cart_redirect_after_add === "yes") {
            window.location = wc_add_to_cart_params.cart_url;
            return;
          }

          $thisButton.text("مشاهده سبد خرید");
          $thisButton.attr("href", cartUrl);
          // Trigger event so themes can refresh other areas.
        }).always(function () {
          $thisButton.addClass("added").removeClass("loading updating-icon");
        });

        return false;
      });
    };

    this.lessonFunctions = function () {
      const swiperConfig = {
        loop: true,
        modules: [Autoplay],

        // autoplay: {
        //   delay: 3000,
        // },
      };

      const swiper = new Swiper(".single-lesson-related-slider", swiperConfig);

      $(".single-lesson-related-navigation")
        .find(".btn-right")
        .on("click", function (e) {
          e.preventDefault();
          swiper.slidePrev();
        });

      $(".single-lesson-related-navigation")
        .find(".btn-left")
        .on("click", function (e) {
          e.preventDefault();
          swiper.slideNext();
        });
    };
  };

  const EdumallCourseInit = new EdumallCourse();
  EdumallCourseInit.init();
})(jQuery);
