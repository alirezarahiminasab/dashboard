$(function () {
  const copy = $(".entry-event-share .copy-link");
  const share = $(".entry-event-share .share-list .share-button");
  const link = window.location.href;

  share.on("click", function (e) {
    e.preventDefault();

    navigator
      .share({
        title: "Hanil Event",
        url: link,
      })
      .then(() => {
        console.log("Thanks for sharing!");
      })
      .catch(console.error);
  });

  copy.on("click", function (e) {
    e.preventDefault();

    navigator.clipboard.writeText(link);
  });
})(jQuery);
