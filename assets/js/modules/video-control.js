import $ from "jquery";

export default function initSlider() {
  const videoWrap = $(".profile-reel-video");
  const playButton = $(".profile-reel-play");
  const video = $(".profile-reel-video video");

  if (videoWrap) {
    playButton.on("click", () => {
      if (playButton.hasClass("hide")) {
        video.trigger("pause");
        playButton.removeClass("hide");
        video.removeAttr("controls");
      } else {
        video.attr("controls", "");
        video.trigger("play");
        playButton.addClass("hide");
      }
    });
  }
}
// Call the initSlider function when the document is ready
$(function () {
  initSlider();
});
