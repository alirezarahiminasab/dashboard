(function ($) {
  $(".admin-ticket-reply button").on("click", function (e) {
    e.preventDefault();
    var adminReply = $("#admin_reply").val();
    var postId = $("#post_id").val();
    const comment = $("#admin_reply").val();

    $.ajax({
      url: ajax_params.ajax_url,
      type: "POST",
      data: {
        action: "save_admin_reply",
        admin_reply: adminReply,
        post_id: postId,
      },
      success: function (response) {
        if (response.success) {
          // Append the new comment to the chat messages
          $(".admin-messages-wrap").append(
            '<div class="admin-chat admin"><p> ادمین:  </p><p>' +
              comment +
              "</p></div>",
          );
          $("#admin_reply").val(""); // Clear the textarea
        } else {
          alert("Failed to send reply.");
        }
      },
    });
  });
})(jQuery);
