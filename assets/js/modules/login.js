(function ($) {
  "use strict";

  var EdumallPopupPlugin = function ($el, options) {
    this.ACTIVE_CLASS = "open";

    this.init = function () {
      var plugin = this;

      $el.on("click", ".popup-overlay, .button-close-popup", function (e) {
        e.preventDefault();
        e.stopPropagation();

        plugin.close();
      });
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
      $popupLogin = $("#popup-user-login"),
      $popupRegister = $("#popup-user-register"),
      $popupLostPassword = $("#popup-user-lost-password");

    $(".edumall-popup").EdumallPopup();

    if ($body.hasClass("required-login") && !$body.hasClass("logged-in")) {
      handlerLogin();
    }

    $body.on("click", ".open-popup-login", function (e) {
      e.preventDefault();
      e.stopPropagation();

      handlerLogin();
    });

    $body.on("click", ".open-popup-register", function (e) {
      e.preventDefault();
      e.stopPropagation();

      handlerRegister();
    });

    $body.on("click", ".open-popup-lost-password", function (e) {
      e.preventDefault();
      e.stopPropagation();

      handlerLostPassword();
    });

    $body.on("click", ".open-popup-instructor-register", function (e) {
      e.preventDefault();
      e.stopPropagation();

      handlerInstructorRegister();
    });

    $body.on("click", ".btn-pw-toggle", function (e) {
      e.preventDefault();
      e.stopPropagation();

      var groupField = $(this).parent(".form-input-password");
      var pwField = groupField.children("input");

      if ("password" === pwField.attr("type")) {
        pwField.attr("type", "text");
        groupField.addClass("show-pw");
      } else {
        pwField.attr("type", "password");
        groupField.removeClass("show-pw");
      }
    });

    function handlerLogin() {
      if ($popupLogin.hasClass("popup-loaded")) {
        $popupLogin.EdumallPopup("open");
      } else {
        $.ajax({
          url: Helpers.getAjaxUrl("lazy_load_template"),
          type: "GET",
          cache: false,
          dataType: "html",
          data: {
            template: $popupLogin.data("template"),
          },
          success: function (response) {
            $popupLogin.find(".popup-content-inner").html(response);
            $popupLogin.addClass("popup-loaded");
            $popupLogin.EdumallPopup("open");

            // Remove inline css.
            $popupLogin
              .find(".mo-openid-app-icons .mo_btn-social")
              .removeAttr("style");
            $popupLogin
              .find(".mo-openid-app-icons .mo_btn-social .mofa")
              .removeAttr("style");
            $popupLogin
              .find(".mo-openid-app-icons .mo_btn-social svg")
              .removeAttr("style");

            var $loginForm = $popupLogin.find("#edumall-login-form");
            $loginForm.validate({
              rules: {
                user_login: {
                  required: true,
                },
                password: {
                  required: true,
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

                      if ("" !== response.redirect_url) {
                        window.location.href = response.redirect_url;
                      } else {
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

    function handlerRegister() {
      console.log(265);
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
            $popupRegister.addClass("popup-loaded");
            $popupRegister.EdumallPopup("open");

            var $registerForm = $popupRegister.find("#edumall-register-form");
            $registerForm.validate({
              rules: {
                firstname: {
                  required: true,
                },
                lastname: {
                  required: true,
                },
                username: {
                  required: true,
                  minlength: 4,
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
                password2: {
                  required: true,
                  minlength: 8,
                  maxlength: 30,
                  equalTo: "#ip_reg_password",
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
                      location.reload();
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
  });
})(jQuery);
