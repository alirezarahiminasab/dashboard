import $ from "jquery";

$(function () {
  // When a tab is clicked
  $(".course-faq-wrap")
    .find(".question")
    .on("click", function (e) {
      e.preventDefault();

      // Get the href attribute
      $(this).closest(".faq-item").toggleClass("active");
    });
});
