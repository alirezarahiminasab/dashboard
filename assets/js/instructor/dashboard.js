import gsap from "gsap";

(function ($) {
  "use strict";
  const EdumallDashboard = function () {
    this.elements = {
      submenus: $(".submenu-header"),
      switchButton: $(".tutor-dashboard-header .switch-container"),
      headerInstructor: $(
        ".tutor-dashboard-header .tutor-dashboard-header-held",
      ),
      headerUser: $(
        ".tutor-dashboard-header .tutor-dashboard-header-enrollment",
      ),
      userMenu: $(".user-dashboard-menus .user-menu"),
      instructorMenu: $(".user-dashboard-menus .instructor-menu"),
    };

    this.init = function (param) {
      const plugin = this;

      plugin.update(plugin.elements);
    };

    this.update = function ($el) {
      $el.switchButton.on("click", function (e) {
        e.preventDefault();

        if (!$(this).hasClass("active")) {
          $(this).addClass("active").siblings(".active").removeClass("active");

          if ($(this).data("usertype") === "user") {
            $el.headerUser.addClass("active");
            $el.userMenu.addClass("active");
            $el.headerInstructor.removeClass("active");
            $el.instructorMenu.removeClass("active");
          } else {
            $el.headerUser.removeClass("active");
            $el.userMenu.removeClass("active");
            $el.headerInstructor.addClass("active");
            $el.instructorMenu.addClass("active");
          }
        }
      });

      $el.submenus.on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        const submenu = $(this).siblings(".tutor-dashboard-sub-menu");

        if (submenu.css("display") === "flex") {
          submenu.hide();
          gsap.to($(this).find(".submenu-arrow"), {
            rotate: "180deg",
          });
        } else {
          submenu.css("display", "flex");
          gsap.to($(this).find(".submenu-arrow"), {
            rotate: "0deg",
          });
        }
      });
    };
  };

  const edumallDashboardInit = new EdumallDashboard();
  edumallDashboardInit.init();
})(jQuery);
