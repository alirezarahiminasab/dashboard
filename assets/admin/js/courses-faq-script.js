jQuery(document).ready(function ($) {
  $("#add-faq-field").on("click", function () {
    var container = $(".faq-fields-container");
    var index = container.children(".faq-field").length;
    var html =
      '<div class="faq-fields">' +
      '<div class="faq-field"><label for="faq_question_' +
      index +
      '">Question</label>' +
      '<input type="text" name="faq_question[]" class="faq-question" />' +
      "</div>" +
      '<div class="faq-field"><label for="faq_answer_' +
      index +
      '">Answer</label>' +
      '<textarea name="faq_answer[]" class="faq-answer" rows="4"></textarea>' +
      '<button type="button" class="button button-secondary delete-faq-field">Delete Question</button></div>' +
      "</div>";
    container.append(html);
  });

  // Handle deletion of question fields
  $(".faq-fields-container").on("click", ".delete-faq-field", function () {
    $(this).closest(".faq-fields").remove(); // Remove the answer field
  });
});
