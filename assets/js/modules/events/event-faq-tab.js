$(function () {
  // When a tab is clicked
  $(".event-faq-wrap")
    .find(".question")
    .on("click", function (e) {
      e.preventDefault();

      // Get the href attribute
      $(this).closest(".faq-item").toggleClass("active");
    });
})(jQuery);
