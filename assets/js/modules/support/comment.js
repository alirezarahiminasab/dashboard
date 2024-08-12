(function ($) {
  const newComment =
    typeof newCommentParams !== "undefined"
      ? newCommentParams.hasNewComment
      : false;

  $(".single-ticket-messages-form").on("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    var commentData = {
      action: "submit_ticket_comment",
      comment: $("#comment").val(),
      comment_post_ID: $('input[name="comment_post_ID"]').val(),
      comment_parent: $('input[name="comment_parent"]').val(),
    };

    $.post(ajax_object.ajax_url, commentData, function (response) {
      if (response.success) {
        // Append the new comment to the chat messages
        $(".single-ticket-messages-wrap").append(
          '<div class="single-ticket-messages-chat user"><p>' +
            commentData.comment +
            "</p></div>",
        );
        $("#comment").val(""); // Clear the textarea
      } else {
        alert("Failed to submit comment. Please try again.");
      }
    });
  });

  if (newComment) {
    $(".tutor-dashboard-menu-support a").append(
      '<span class="support-new-message"></span>',
    );
  }
})(jQuery);
