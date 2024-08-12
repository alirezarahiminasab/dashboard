import $ from "jquery";
import gsap from "gsap";

// Function to show toast notifications
const toast = function showToast(message, status) {
  const toast = $("#toast");
  const successSrc = toast.find("img").data("success");
  const errorSrc = toast.find("img").data("error");
  const warningSrc = toast.find("img").data("warning");
  let timer = null;

  // Clear previous classes and styles to ensure consistency
  toast.removeClass("success error warning");
  gsap.killTweensOf(toast); // Kill any ongoing animations
  gsap.set(toast, { y: "-100%" }); // Reset the position before showing

  switch (status) {
    case "success":
      toast.addClass("success");
      toast.find("img").attr("src", successSrc);
      break;
    case "error":
      toast.addClass("error");
      toast.find("img").attr("src", errorSrc);
      break;
    case "warning":
      toast.addClass("warning");
      toast.find("img").attr("src", warningSrc);
      break;
  }
  toast.find("p").text(message);
  toast.show(); // Show the toast before animating
  gsap.to(toast, {
    y: "1rem",
    display: "flex",
    duration: 1,
    ease: "power4.inOut",
  });

  timer = setTimeout(() => {
    gsap.to(toast, {
      y: "-100%",
      display: "none",
      duration: 1,
      ease: "power4.inOut",
      onComplete: () => {
        clearTimeout(timer); // Ensure the toast is hidden after the animation
      },
    });
  }, 5000);
};

export default toast;
