import $ from "jquery";

$(function () {
  let counter = parseInt($(".group-ticket .ticket-counter input").val());
  // When a tab is clicked
  $(".group-ticket .ticket-counter .add").on("click", function (e) {
    $(this)
      .parent()
      .find("input")
      .val(+$(this).parent().find("input").val() + 1);
  });

  $(".group-ticket .ticket-counter .minus").on("click", function (e) {
    if (+$(this).parent().find("input").val() > 3)
      $(this)
        .parent()
        .find("input")
        .val(+$(this).parent().find("input").val() - 1);
    else $(this).parent().find("input").val(3);
  });
});
