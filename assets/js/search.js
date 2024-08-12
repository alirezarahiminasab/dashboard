import gsap from "gsap";

(function ($) {
  "use strict";
  const EdumallSearch = function () {
    this.elements = {
      search: $(".search-icon"),
      searchWrap: $(".search-wrap"),
    };

    this.init = function () {
      const plugin = this;

      plugin.getElements(plugin.elements);
    };

    this.getElements = function ($el) {
      $el.search.on("click", function (e) {
        e.preventDefault();

        $el.searchWrap.css("display", "flex");
      });

      $el.searchWrap.find(".search-wrap-input-back").on("click", function (e) {
        $el.searchWrap.find("input").val("").blur();
        $el.searchWrap.find(".search-wrap-result-item-footer").html("");
        $el.searchWrap.hide();
        $("body").css("overflow", "auto");
      });

      $el.searchWrap
        .find("input")
        .on("focus", function (e) {
          e.preventDefault();

          $el.searchWrap.find(".search-wrap-input-close").show();
        })
        .on("blur", function (e) {
          e.preventDefault();

          if (e.target.value.length === 0) {
            $el.searchWrap.find(".search-wrap-input-close").hide();
          }
        });

      $el.searchWrap.find("input").on("input", function (e) {
        e.preventDefault();

        if (e.target.value.length === 0) {
          $el.searchWrap.find(".search-wrap-input-close").hide();
        }

        $el.searchWrap.find(".search-wrap-input-close").show();
      });

      $el.searchWrap.find(".search-wrap-input-close").on("click", function (e) {
        $el.searchWrap.find("input").val("").blur();
      });

      $el.searchWrap.find(".search-wrap-input").on("submit", function (e) {
        // e.preventDefault();
        const value = $(this).find("#search-wrap-input-value").val();

        // $.ajax({
        //   url: ajax_object.ajax_url,
        //   type: "POST",
        //   data: {
        //     action: "search",
        //     searchQuery: value,
        //   },
        //   beforeSend: function () {
        //     $el.searchWrap
        //       .find(".search-wrap-result-item footer")
        //       .html("<span class='search-loader'></span>");
        //   },
        //   success: (response) => {
        //     const result = response.result || "";

        //     $("body").css("overflow", "hidden");

        //     if (Boolean(result.contents)) {
        //       $el.searchWrap
        //         .find(".result-courses footer")
        //         .html(result.contents.courses);

        //       $el.searchWrap
        //         .find(".result-events footer")
        //         .html(result.contents.events);

        //       $el.searchWrap
        //         .find(".result-posts footer")
        //         .html(result.contents.posts);
        //     } else {
        //       $el.searchWrap.find(".result-courses footer").html("");

        //       $el.searchWrap.find(".result-events footer").html("");

        //       $el.searchWrap.find(".result-posts footer").html("");
        //     }

        //     $el.searchWrap
        //       .find(".result-users footer")
        //       .html(response.result.users);
        //   },
        //   error: (e) => {
        //     // Handle error
        //     console.log(e);
        //   },
        // });
      });
    };
  };

  const edumallSearchInit = new EdumallSearch();
  edumallSearchInit.init();
})(jQuery);
