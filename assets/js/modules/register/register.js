import gsap from "gsap";
import toast from "../../toast";
import bcrypt from "bcryptjs";

/**
 * Timer Section
 */
var timerInterval;

function stopTimer() {
  clearInterval(timerInterval);
}

(function ($) {
  "use strict";

  /**
   * Register and login section
   */

  var EdumallPopupPlugin = function ($el, options) {
    this.ACTIVE_CLASS = "open";

    this.init = function () {
      var plugin = this;

      $el.on(
        "click",
        ".popup-overlay, .button-popup-close .close",
        function (e) {
          e.preventDefault();
          e.stopPropagation();
          stopTimer();

          $("body").css("overflow", "auto");
          $(".popup-content-inner").html("");

          plugin.close();
        },
      );
    };

    this.open = function () {
      var plugin = this;

      $(".edumall-popup").EdumallPopup("close");

      $el.addClass(plugin.ACTIVE_CLASS);
    };

    this.close = function () {
      var plugin = this;

      $el.removeClass(plugin.ACTIVE_CLASS);
    };
  };

  $.fn.EdumallPopup = function (methodOrOptions) {
    var method =
      typeof methodOrOptions === "string" ? methodOrOptions : undefined;

    if (method) {
      var EdumallPopups = [];

      this.each(function () {
        var $el = $(this);
        var EdumallPopup = $el.data("EdumallPopup");
        EdumallPopups.push(EdumallPopup);
      });

      var args =
        arguments.length > 1
          ? Array.prototype.slice.call(arguments, 1)
          : undefined;

      var results = [];

      this.each(function (index) {
        var EdumallPopup = EdumallPopups[index];

        if (!EdumallPopup) {
          console.warn("$.EdumallPopup not instantiated yet");
          console.info(this);
          results.push(undefined);
          return;
        }

        if (typeof EdumallPopup[method] === "function") {
          var result = EdumallPopup[method].apply(EdumallPopup, args);
          results.push(result);
        } else {
          console.warn("Method '" + method + "' not defined in $.EdumallPopup");
        }
      });

      return results.length > 1 ? results : results[0];
    } else {
      var options =
        typeof methodOrOptions === "object" ? methodOrOptions : undefined;

      return this.each(function () {
        var $el = $(this);
        var EdumallPopup = new EdumallPopupPlugin($el, options);

        $el.data("EdumallPopup", EdumallPopup);

        EdumallPopup.init();
      });
    }
  };
})(jQuery);

(function ($) {
  "use strict";

  function updateTimerDisplay(minutes, seconds) {
    var formattedTime = pad(minutes) + ":" + pad(seconds);
    $(".verification-timer .timer").text(formattedTime);
  }

  function startTimer(minutes, seconds) {
    timerInterval = setInterval(function () {
      if (seconds === 0 && minutes === 0) {
        $(".edumall-register-verify-code .send-code").addClass("active");
        stopTimer();
        return;
      }

      if (seconds === 0) {
        seconds = 59;
        minutes--;
      } else {
        seconds--;
      }

      updateTimerDisplay(minutes, seconds);
    }, 1000);
  }

  function pad(num) {
    return num < 10 ? "0" + num : num;
  }

  $("#stopTimer").click(function () {
    stopTimer();
  });

  $(document).ready(function () {
    var messages = $edumallLogin.validatorMessages;

    jQuery.extend(jQuery.validator.messages, {
      required: messages.required,
      remote: messages.remote,
      email: messages.email,
      url: messages.url,
      date: messages.date,
      dateISO: messages.dateISO,
      number: messages.number,
      digits: messages.digits,
      creditcard: messages.creditcard,
      equalTo: messages.equalTo,
      accept: messages.accept,
      maxlength: jQuery.validator.format(messages.maxlength),
      minlength: jQuery.validator.format(messages.minlength),
      rangelength: jQuery.validator.format(messages.rangelength),
      range: jQuery.validator.format(messages.range),
      max: jQuery.validator.format(messages.max),
      min: jQuery.validator.format(messages.min),
    });

    var Helpers = edumall.Helpers,
      $body = $("body"),
      $popupPreLoader = $("#popup-pre-loader"),
      $popupRegister = $("#popup-user-register"),
      $popupLostPassword = $("#popup-user-lost-password");

    $(".edumall-popup").EdumallPopup();

    $body.on("click", ".open-login-popup", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $body.css("overflow", "hidden");

      handlerRegister();
    });

    function handlerRegister() {
      if ($popupRegister.hasClass("popup-loaded")) {
        $popupRegister.EdumallPopup("open");
      } else {
        $.ajax({
          url: Helpers.getAjaxUrl("lazy_load_template"),
          type: "GET",
          cache: false,
          dataType: "html",
          data: {
            template: $popupRegister.data("template"),
          },
          success: function (response) {
            $popupRegister.find(".popup-content-inner").html(response);
            $popupRegister.EdumallPopup("open");

            // Send Code For desired phone
            const sendCode = $(".edumall-register-get-phone");

            sendCode.on("submit", (e) => {
              e.preventDefault();
              handleSendCode();
            });
          },
          error: function (MLHttpRequest, textStatus, errorThrown) {
            console.log(errorThrown);
          },
          beforeSend: function () {
            $(".edumall-popup").EdumallPopup("close");
            $popupPreLoader.addClass("open");
          },
          complete: function () {
            $popupPreLoader.removeClass("open");
          },
        });
      }
    }

    function handleSendCode() {
      // Get the phone number from the form
      const phoneNumber = $("#ip_reg_phone").val();
      const phonePattern = new RegExp("^(09[0-9]{2}[0-9]{7})$");
      const sendAgain = $(".edumall-register-verify-code .send-code");
      const editPhone = $(".verification-component-edit-phone a");
      const seconds = 0;
      const minutes = 2;

      editPhone.on("click", (e) => {
        e.preventDefault();

        stopTimer();
        handlerRegister();
      });

      sendAgain.off("click").on("click", (e) => {
        e.preventDefault();

        if (sendAgain.hasClass("active")) {
          sendAgain.removeClass("active");

          handleSendCode();
        }
      });

      // start timer on phone input
      startTimer(minutes, seconds);

      if (phonePattern.test(phoneNumber)) {
        // AJAX request to send verification code
        $.ajax({
          type: "POST",
          url: ajax_object.ajax_url, // Use WordPress AJAX URL
          data: {
            action: "send_verification_code",
            phone_number: phoneNumber,
          },
          beforeSend: function () {
            $(".edumall-register-get-phone button").attr("disabled", true);
            $(".edumall-register-get-phone button").append(
              '<span class="loader"></span>',
            );
          },
          success: function (response) {
            // Proceed to step 2 (display verification code input and insert phone number into the title)
            const passStatus = response.has_password;
            if (passStatus) {
              $("#edumall-register-verify-code .verification-pass").show();
            }
            const verifyCode = response.verify_code;
            const status = response.status;
            handleVerifyCode(verifyCode, status, phoneNumber);
          },
          error: function (error) {
            // Handle errors
            console.log(error);
          },
        });
      } else {
        $(".reg-phone .error-message").addClass("active");
        $(".reg-phone .form-control").addClass("error");
      }
    }

    function handleVerifyCode($verifyCode, $status, $phoneNumber) {
      $("#edumall-register-get-phone").hide();
      $("#edumall-register-verify-code").addClass("active");
      // $(".button-close-return-popup .return").addClass("active");
      $("#get-phone-title").hide();
      $("#verify-phone-title").show();
      $(".phone-number").text($phoneNumber);

      const verifyCodeForm = $(".edumall-register-verify-code");
      verifyCodeForm.off("submit").on("submit", (e) => {
        e.preventDefault();

        const userInputCode = $("#verification-code").val();

        if (bcrypt.compareSync(userInputCode, $verifyCode)) {
          if ($status === true) {
            $.ajax({
              type: "POST",
              url: ajax_object.ajax_url, // Use WordPress AJAX URL
              data: {
                action: "child_user_login",
                phone_number: $phoneNumber,
              },
              beforeSend: function () {
                $(".edumall-register-verify-code button").attr(
                  "disabled",
                  true,
                );
                $(".edumall-register-verify-code button").append(
                  '<span class="loader"></span>',
                );
              },
              success: function (response) {
                window.location.href = "/";
              },
            });
            return;
          }
          $(".login-child-password").remove();
          handleUserMeta($phoneNumber);
        }
      });
    }

    function handleUserMeta($phoneNumber) {
      $("#edumall-register-verify-code").hide();
      $("#verify-phone-title").hide();
      $("#edumall-register-meta").addClass("active");

      const metaForm = $("#edumall-register-meta");

      metaForm.on("submit", function (e) {
        e.preventDefault();

        const $name = $("#meta-name").val();
        const $referCode = $("#meta-refer").val();

        $.ajax({
          type: "POST",
          url: ajax_object.ajax_url, // Use WordPress AJAX URL
          data: {
            action: "save_user_meta",
            name: $name,
            phone_number: $phoneNumber,
            refer_code: $referCode,
          },
          beforeSend: function () {
            $(".edumall-register-meta button").attr("disabled", true);
            $(".edumall-register-meta button").append(
              '<span class="loader"></span>',
            );
          },
          success: function (response) {
            const $user_id = response.user_id;
            $("#user_hidden_id").val($user_id);
            $(".instructor-settings").data("user", $user_id);

            if (response.result) {
              handleFavorites();
            }
          },
          error: function (error) {
            // Handle errors
            console.log(error);
          },
        });
      });
    }

    function handleFavorites() {
      $("#edumall-register-meta").hide();
      $("#favorites-title").show();
      $("#edumall-register-favorites").addClass("active");

      const favoritesForm = $("#edumall-register-favorites");

      $(".fav-cats a").on("click", function (e) {
        e.preventDefault();

        $(this).toggleClass("selected");
      });

      favoritesForm.on("submit", (e) => {
        e.preventDefault();
        const $favorites = [];
        $(".fav-cats a.selected").each(function (i, el) {
          $favorites.push($(el).text());
        });

        $.ajax({
          type: "POST",
          url: ajax_object.ajax_url, // Use WordPress AJAX URL
          data: {
            action: "save_user_favorites",
            favorites: $favorites,
            user_id: $("#user_hidden_id").val(),
          },
          beforeSend: function () {
            $(".edumall-register-favorites button").attr("disabled", true);
            $(".edumall-register-favorites button").append(
              '<span class="loader"></span>',
            );
          },
          success: function (response) {
            handleUserState();
          },
        });
      });
    }

    function handleUserState($user_id) {
      $("#edumall-register-favorites").hide();
      $(".popup-title__text").hide();
      $("#state-title").show();
      $("#edumall-register-state").addClass("active");

      $("#edumall-register-state .state-wrap").on("click", function (e) {
        $(this).addClass("active").siblings().removeClass("active");
        $(this).siblings(".state-button").show();
        $(this).find("input").prop("checked", true);

        const userState = $(this).find("input").val();

        if (userState === "instructor") {
          $(this)
            .siblings(".state-button")
            .find("button")
            .text("تکمیل اطلاعات");
        } else if (userState === "tutor") {
          $(this)
            .siblings(".state-button")
            .find("button")
            .text("ورود به عنوان فراگیر");
        }
      });

      $("#edumall-register-state").on("submit", function (e) {
        e.preventDefault();

        const userState = $(this).find(".state-wrap.active input").val();

        if (userState === "instructor") {
          handleBecomeInstructor();
        } else if (userState === "academy") {
          handleBecomeAcademy();
        } else if (userState === "tutor") {
          $.ajax({
            type: "POST",
            url: ajax_object.ajax_url, // Use WordPress AJAX URL
            data: {
              action: "child_user_login",
              user_id: $("#user_hidden_id").val(),
            },
            success: function (response) {
              const result = response.result;
              window.location.href = "/";
            },
          });
        }
      });
    }

    function handleBecomeAcademy() {
      $(".become-academy").show();
      $("#state-title").hide();
      $("#edumall-register-state").hide();
      $(".popup-register-logo").hide();
      let timer = null;
      const username = $(".become-academy-form .academy-username")
        .find("input")
        .val();

      // Handle profile picture input change event
      $(".become-academy-form")
        .find("#academy_photo_dialogue_box")
        .on("change", function (e) {
          getImgData();
        });

      // Handle academy username
      $(".become-academy-form")
        .find("#academy_profile_username")
        .on("input", function (e) {
          const english = /^[A-Za-z0-9]*$/;
          const input = $(this).parent();
          const tempUsername = $(this).val();

          input.find("svg").hide();

          clearTimeout(timer);
          if (e.target.value.length > 3) {
            if (english.test($(this).val())) {
              timer = setTimeout(() => {
                if ($(this).val() === username) {
                  $(this).removeClass();
                  return;
                }
                $(this).parent().append('<span class="loading"></span>');
                $.ajax({
                  url: ajax_object.ajax_url,
                  type: "POST",
                  data: {
                    action: "check_username",
                    username: tempUsername,
                  },
                  success: (response) => {
                    // Handle successful upload
                    input.find(".loading").remove();
                    if (response.result.length > 0) {
                      input
                        .find("input")
                        .addClass("rejected")
                        .removeClass("accepted");
                      input.find(".academy-username-input-reject").show();
                      gsap.fromTo(
                        input.find("svg"),
                        { strokeDasharray: "100%", strokeDashoffset: "100%" },
                        {
                          strokeDasharray: "50%",
                          strokeDashoffset: "0%",
                          duration: 1,
                        },
                      );
                    } else {
                      input
                        .find("input")
                        .addClass("accepted")
                        .removeClass("rejected");
                      input.find(".academy-username-input-accept").show();
                      gsap.fromTo(
                        input.find("svg"),
                        { strokeDasharray: "100%", strokeDashoffset: "100%" },
                        {
                          strokeDasharray: "100%",
                          strokeDashoffset: "0%",
                          duration: 1,
                        },
                      );
                    }
                  },
                  error: (e) => {
                    // Handle error
                    console.log(e);
                  },
                });
              }, 2000);
            } else {
              toast("فقط اعداد و کاراکترهای انگلیسی مجاز است", "error");
            }
          }
        });

      // Handle academy Story
      $(".become-academy-form")
        .find("textarea")
        .on("input", function (e) {
          const story = $(this).val();
          if (story.length < 250) {
            $(".academy-story-box-limit-start").html(story.length);
          } else {
            $(this).val($(this).val().substring(0, 250));
            if (story.length === 250) {
              $(".academy-story-box-limit-start").html(story.length);
            }
            return;
          }
        });

      // Handle upload file
      $(".become-academy-form #academy_story_video_file").on(
        "change",
        function (e) {
          handleFiles(
            e.target.files,
            formatBytes,
            uploadFile,
            updateProgressBar,
          );
        },
      );

      // Handle close button
      $(".become-academy-form")
        .find(".story-video-upload-close")
        .on("click", resetUploadBox);

      // Handle add tags button
      $(".become-academy-form")
        .find(".academy-tags-input a")
        .on("click", function (e) {
          e.preventDefault();

          const inputValue = $(".become-academy-form")
            .find(".academy-tags-input input")
            .val();

          if (inputValue.length >= 2) {
            const tagValue = $("<div>")
              .addClass("academy-tags-wrap-value")
              .append(`<p>${inputValue}</p>`)
              .append(
                `<img class='academy-tags-delete' src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgaWQ9InZ1ZXNheC9saW5lYXIvY2xvc2UtY2lyY2xlIj4KPGcgaWQ9ImNsb3NlLWNpcmNsZSI+CjxwYXRoIGlkPSJWZWN0b3IiIGQ9Ik0xMiAyMkMxNy41IDIyIDIyIDE3LjUgMjIgMTJDMjIgNi41IDE3LjUgMiAxMiAyQzYuNSAyIDIgNi41IDIgMTJDMiAxNy41IDYuNSAyMiAxMiAyMloiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMiIgZD0iTTkuMTY5OTIgMTQuODI5OUwxNC44Mjk5IDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMyIgZD0iTTE0LjgyOTkgMTQuODI5OUw5LjE2OTkyIDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjwvZz4KPC9nPgo8L3N2Zz4K'/>
                <input type='hidden' name='tags[]'>
                `,
              );

            $(".become-academy-form")
              .find(".academy-tags-wrap")
              .append(tagValue);
            $(".become-academy-form").find(".academy-tags-input input").val("");
          }

          // Handle delete tag
          $(".become-academy-form")
            .find(".academy-tags-delete")
            .on("click", function (e) {
              e.preventDefault();
              const tagWrap = $(this).parent();
              const tag = $(this).siblings("p").text();

              tagWrap.remove();
            });
        });

      // Handle Login
      $(".become-academy-form").on("submit", function (e) {
        e.preventDefault();
        const $user_id = $("#user_hidden_id").val();
        const $username = $(
          ".become-academy-form #academy_profile_username",
        ).val();
        const $profession = $(
          ".become-academy-form #academy_profile_profession",
        ).val();
        const $user_story = $(".become-academy-form #academy_story_text").val();
        const user_picture = $(".become-academy-form .profile-picture").attr(
          "src",
        );
        const tags = $(
          ".become-academy-form #academy_profile_tags .academy-tags-wrap-value p",
        );
        const tagsArr = [];

        if (tags.length > 0) {
          tags.each(function (index, el) {
            tagsArr.push($(el).text());
          });
        }

        $.ajax({
          type: "POST",
          url: ajax_object.ajax_url, // Use WordPress AJAX URL
          data: {
            action: "save_academy_metadata",
            user_id: $user_id,
            tags: tagsArr,
            becomeInstructor: true,
            username: $username,
            profession: $profession,
            storyText: $user_story,
            userPicture: user_picture,
          },
          success: function (response) {
            const result = response.result;
            $("#user_hidden_id").remove();

            if (result) {
              window.location.href = "/";
            }
          },
        });
      });
    }

    function handlerLostPassword() {
      if ($popupLostPassword.hasClass("popup-loaded")) {
        $popupLostPassword.EdumallPopup("open");
      } else {
        $.ajax({
          url: Helpers.getAjaxUrl("lazy_load_template"),
          type: "GET",
          cache: false,
          dataType: "html",
          data: {
            template: $popupLostPassword.data("template"),
          },
          success: function (response) {
            $popupLostPassword.find(".popup-content-inner").html(response);
            $popupLostPassword.addClass("popup-loaded");
            $popupLostPassword.EdumallPopup("open");

            var $lostPasswordForm = $popupLostPassword.find(
              "#edumall-lost-password-form",
            );
            $lostPasswordForm.on("submit", function (e) {
              e.preventDefault();

              var $form = $(this);
              var $submitButton = $form.find('button[type="submit"]');

              if ($submitButton.attr("disabled") === true) {
                return false;
              }

              $submitButton.attr("disabled", true);

              $.ajax({
                type: "post",
                url: $edumall.ajaxurl,
                dataType: "json",
                data: $form.serialize(),
                success: function (response) {
                  if (!response.success) {
                    $form
                      .find(".form-response-messages")
                      .html(response.messages)
                      .addClass("error")
                      .show();
                  } else {
                    $form
                      .find(".form-response-messages")
                      .html(response.messages)
                      .addClass("success")
                      .show();
                  }
                },
                beforeSend: function () {
                  $form
                    .find(".form-response-messages")
                    .html("")
                    .removeClass("error success")
                    .hide();
                  $form.find('button[type="submit"]').addClass("updating-icon");
                },
                complete: function () {
                  $form
                    .find('button[type="submit"]')
                    .removeClass("updating-icon")
                    .attr("disabled", false);
                },
              });
            });
          },
          error: function (MLHttpRequest, textStatus, errorThrown) {
            console.log(errorThrown);
          },
          beforeSend: function () {
            $(".edumall-popup").EdumallPopup("close");
            $popupPreLoader.addClass("open");
          },
          complete: function () {
            $popupPreLoader.removeClass("open");
          },
        });
      }
    }

    function handlerInstructorRegister() {
      var $popup = $("#edumall-popup-instructor-register");

      if ($popup.hasClass("popup-loaded")) {
        $popup.EdumallPopup("open");
      } else {
        $.ajax({
          url: Helpers.getAjaxUrl("lazy_load_template"),
          type: "GET",
          cache: false,
          dataType: "html",
          data: {
            template: $popup.data("template"),
          },
          success: function (response) {
            $popup.find(".popup-content-inner").html(response);
            $popup.addClass("popup-loaded");
            $popup.EdumallPopup("open");

            var $form = $popup.find("form");
            $form.validate({
              rules: {
                fullname: {
                  required: true,
                },
                username: {
                  required: true,
                },
                email: {
                  required: true,
                  email: true,
                },
                password: {
                  required: true,
                  minlength: 8,
                  maxlength: 30,
                },
              },
              submitHandler: function (form) {
                var $form = $(form);
                var $submitButton = $form.find('button[type="submit"]');

                if ($submitButton.attr("disabled") === true) {
                  return false;
                }

                $submitButton.attr("disabled", true);

                $.ajax({
                  url: $edumall.ajaxurl,
                  type: "POST",
                  cache: false,
                  dataType: "json",
                  data: $form.serialize(),
                  success: function (response) {
                    if (!response.success) {
                      $form
                        .find(".form-response-messages")
                        .html(response.messages)
                        .addClass("error")
                        .show();
                    } else {
                      $form
                        .find(".form-response-messages")
                        .html(response.messages)
                        .addClass("success")
                        .show();

                      if (response.redirect) {
                        location.reload();
                      }
                    }
                  },
                  beforeSend: function () {
                    $form
                      .find(".form-response-messages")
                      .html("")
                      .removeClass("error success")
                      .hide();
                    $form
                      .find('button[type="submit"]')
                      .addClass("updating-icon");
                  },
                  complete: function () {
                    $form
                      .find('button[type="submit"]')
                      .removeClass("updating-icon")
                      .attr("disabled", false);
                  },
                });
              },
            });
          },
          error: function (MLHttpRequest, textStatus, errorThrown) {
            console.log(errorThrown);
          },
          beforeSend: function () {
            $(".edumall-popup").EdumallPopup("close");
            $popupPreLoader.addClass("open");
          },
          complete: function () {
            $popupPreLoader.removeClass("open");
          },
        });
      }
    }

    // if ($(".become-instructor").hasClass("active")) {
    //   handleBecomeInstructor();
    // }
  });
})(jQuery);
