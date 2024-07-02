import gsap from "gsap";
import Swiper from "swiper";
import { Autoplay, FreeMode, Pagination } from "swiper/modules";

import "swiper/css";
import "swiper/css/pagination";

(function ($) {
  "use strict";
  const EdumallLandingPage = function () {
    this.elements = {
      landingPage: $(".home-slider"),
      tagItems: $(".home-tags"),
      freeItems: $(".home-free"),
      allItems: $(".home-all"),
      instructors: $(".home-instructors"),
    };

    this.init = function (param) {
      const plugin = this;

      plugin.fetchPaidContent(
        plugin.elements.allItems.find(".home-all-category-meta"),
        plugin,
      );

      plugin.fetchFreeContent(
        plugin.elements.freeItems.find(".home-free-categories a"),
        plugin,
      );

      plugin.slider(
        plugin.elements.instructors.find(".home-instructors-content-slider"),
      );

      plugin.slider(plugin.elements.allItems.find(".home-all-content-slider"));

      plugin.slider(
        plugin.elements.freeItems.find(".home-free-content-slider"),
      );
      plugin.slider(plugin.elements.tagItems);
      plugin.slider(plugin.elements.landingPage);
    };

    this.slider = function ($element) {
      let swiperConfig = {};

      const pagination =
        $element.data("pagination") && $element.find(".swiper-pagination")[0];
      const navBtn = $element.data("nav") ? $element.data("nav") : false;
      const slides = $element.data("slides") ? $element.data("slides") : 1;
      const space = $element.data("space") ? $element.data("space") : "0";
      const free = $element.data("free") ? $element.data("free") : false;
      const speed = $element.data("speed") ? $element.data("speed") : "300";
      const loop = $element.data("loop") ? $element.data("loop") : false;

      if ($element.data("autoplay")) {
        swiperConfig = {
          spaceBetween: space,
          speed: speed,
          freeMode: free,
          loop: loop,
          slidesPerView: slides,
          modules: [Pagination, Autoplay, FreeMode],
          // If we need pagination
          pagination: {
            el: pagination,
          },
          autoplay: {
            delay: $element.data("autoplay"),
            reverseDirection: true,
          },
        };
      } else {
        swiperConfig = {
          spaceBetween: space,
          speed: speed,
          freeMode: free,
          loop: loop,
          slidesPerView: slides,
          modules: [Pagination, FreeMode],
          // If we need pagination
          pagination: {
            el: pagination,
          },
        };
      }
      const swiper = new Swiper($element[0], swiperConfig);

      if (navBtn === true) {
        if (swiper.isBeginning) {
          $($element).siblings().find(".btn-right").hide();
          $($element)
            .siblings()
            .find(".btn-right")
            .parent()
            .css("justify-content", "end");
        }

        swiper.off("slideChange").on("slideChange", function () {
          if (swiper.isBeginning) {
            $($element).siblings().find(".btn-right").hide();
            $($element).siblings().find(".btn-left").show();
            $($element)
              .siblings()
              .find(".btn-right")
              .parent()
              .css("justify-content", "end");
            return;
          } else if (swiper.isEnd) {
            $($element).siblings().find(".btn-left").hide();
            $($element).siblings().find(".btn-right").show();
            $($element)
              .siblings()
              .find(".btn-right")
              .parent()
              .css("justify-content", "start");
            return;
          } else {
            $($element).siblings().find(".btn-left").show();
            $($element).siblings().find(".btn-right").show();
            $($element)
              .siblings()
              .find(".btn-right")
              .parent()
              .css("justify-content", "space-between");
          }
        });

        $($element)
          .siblings()
          .find(".btn-right")
          .on("click", function (e) {
            e.preventDefault();
            swiper.slidePrev();
          });

        $($element)
          .siblings()
          .find(".btn-left")
          .on("click", function (e) {
            e.preventDefault();
            swiper.slideNext();
          });
      }
    };

    this.fetchFreeContent = function ($element, plugin) {
      $element.on("click", function (e) {
        e.preventDefault();
        const category = $(this).data("category");
        $(this).addClass("active").siblings().removeClass("active");

        $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "get_courses",
            category: category,
            type: "free",
          },
          beforeSend: () => {
            // Handle before send
            $element
              .parent()
              .siblings(".home-free-content")
              .html('<span class="loader"></span>');
          },
          success: (response) => {
            // Handle successful upload
            $element
              .parent()
              .siblings(".home-free-content")
              .html(response.result);

            plugin.slider(
              plugin.elements.freeItems.find(".home-free-content-slider"),
            );
          },
          error: (e) => {
            // Handle error
            console.log(e);
          },
        });
      });
    };

    this.fetchPaidContent = function ($element, plugin) {
      $element.on("click", function (e) {
        e.preventDefault();
        const current = $(this);
        const category = $(this).data("category");
        $(this)
          .parent()
          .addClass("active")
          .siblings()
          .removeClass("active")
          .find(".home-all-content")
          .remove();

        $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "get_courses",
            category: category,
            type: "all",
          },
          beforeSend: () => {
            // Handle before send
            $(current).siblings(".home-all-content").remove();

            $(current)
              .parent()
              .append(
                '<div class="home-all-content"><span class="loader"></span></div>',
              );
          },
          success: (response) => {
            // Handle successful upload
            $(current).siblings(".home-all-content").html(response.result);

            plugin.slider(
              plugin.elements.allItems.find(".home-all-content-slider"),
            );
          },
          error: (e) => {
            // Handle error
            console.log(e);
          },
        });
      });
    };
  };

  const edumallLandingOPageInit = new EdumallLandingPage();
  edumallLandingOPageInit.init();
})(jQuery);
