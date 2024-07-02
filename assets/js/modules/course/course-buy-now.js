import $ from "jquery";
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

$(function () {
  // When a tab is clicked
  const view_port = window.innerHeight;
  const buy_now = $(".footer-menu");
  const footer = $(".footer-wrapper .footer");
  const buy_now_height = $(".footer-menu").innerHeight();
  const footer_menu_height = $(".footer-wrapper .footer-menu").outerHeight(
    true,
  );
  const footer_padding = parseInt(footer.css("paddingBottom"));
  const body_height = $("body").outerHeight();

  if (buy_now.length > 0) {
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: "body",
        start: `${
          body_height - footer_menu_height - buy_now_height
        }px ${view_port}px`,
        end: `${body_height - footer_menu_height}px ${
          view_port - buy_now_height
        }px`,
        scrub: 1,
      },
    });
    tl.to(footer, { paddingBottom: buy_now_height });
  }
});
