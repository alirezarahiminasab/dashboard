import gsap from "gsap";
import Swiper from "swiper";
import { Autoplay, FreeMode, Pagination } from "swiper/modules";

import "swiper/css";
import "swiper/css/pagination";

(function ($) {
  "use strict";
  const EdumallLandingPage = function () {
    this.elements = {
      home: $(".home"),
    };

    this.init = function (param) {
      const plugin = this;

      plugin.fetchPaidContent(
        plugin.elements.home.find(".home-all-category-meta"),
        plugin,
      );

      plugin.fetchFreeContent(
        plugin.elements.home.find(".home-free-categories a"),
        plugin,
      );

      plugin.slider(
        plugin.elements.home.find(".home-instructors-content-slider"),
      );
      plugin.slider(plugin.elements.home.find(".home-all-content-slider"));
      plugin.slider(plugin.elements.home.find(".home-events-content-slider"));
      plugin.slider(plugin.elements.home.find(".home-free-content-slider"));
      plugin.slider(plugin.elements.home.find(".home-tags"));
      plugin.slider(plugin.elements.home.find(".home-slider"));
    };

    this.slider = function ($element) {
      let swiperConfig = {};

      const numberOfSlides = $element.find(".swiper-slide").length;
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
          loop: slides >= numberOfSlides ? false : loop,
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
          loop: slides >= numberOfSlides ? false : loop,
          slidesPerView: slides,
          modules: [Pagination, FreeMode],
          // If we need pagination
          pagination: {
            el: pagination,
          },
        };
      }

      if (numberOfSlides > 0) {
        const swiper = new Swiper($element[0], swiperConfig);

        if (navBtn === true) {
          if (swiper.isBeginning) {
            $($element).siblings(".btn-right").hide();
          }

          swiper.off("slideChange").on("slideChange", function () {
            if (swiper.isBeginning) {
              $($element).siblings(".btn-right").hide();
              $($element).siblings(".btn-left").show();
              return;
            } else if (swiper.isEnd) {
              $($element).siblings(".btn-left").hide();
              $($element).siblings(".btn-right").show();
              return;
            } else {
              $($element).siblings(".btn-left").show();
              $($element).siblings(".btn-right").show();
            }
          });

          $($element)
            .siblings(".btn-right")
            .on("click", function (e) {
              e.preventDefault();
              swiper.slidePrev();
            });

          $($element)
            .siblings(".btn-left")
            .on("click", function (e) {
              e.preventDefault();
              swiper.slideNext();
            });
        }
      }
    };

    this.fetchFreeContent = function ($element, plugin) {
      $element.on("click", function (e) {
        e.preventDefault();
        const category = $(this).data("category");
        if ($(this).hasClass("active")) return;
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
            plugin.init();
          },
          error: (e) => {
            // Handle error
            console.log(e);
          },
        });
      });
    };

    this.fetchPaidContent = function ($element, plugin) {
      $element.find("a").on("click", (e) => {
        e.stopPropagation();
      });

      $element.on("click", function (e) {
        e.preventDefault();
        const current = $(this);
        const isMobile = $(this).data("mobile");
        const category = $(this).data("category");
        if ($(this).parent().hasClass("active")) {
          return;
        }

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

            if (Boolean(isMobile)) {
              $(current)
                .parent()
                .append(
                  '<div class="home-all-content"><span class="loader"></span></div>',
                );
            } else {
              $(".home-all-content").html("<span class='loader'></span>");
            }
          },
          success: (response) => {
            // Handle successful upload
            $(".home-all-content").html(response.result);

            plugin.init();
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
