import toast from "../toast";
import gsap from "gsap";

(function ($) {
  "use strict";

  class EdumallUserDashboard {
    constructor() {
      this.elements = {
        userDashboard: $(".user-dashboard"),
        userForm: $(".dashboard-settings-form"),
        userPicture: $("#user_profile_cover_photo_editor"),
        userAccountant: $(".withdrawal-account-form"),
        userProfileIcon: $(".desktop-header-profile"),
        userDashboardLinks: $(".user-dashboard-menus div.active a"),
      };

      this.timer = null;

      this.setProfilePicture();
      this.saveUserMetadata();
      this.checkUsername();
      this.handleFavorites();
      this.handleAccountant();
      this.handleDashboardMenu();
      this.handleDesktopLinks();
    }

    changeUrl(newPath, type) {
      if (typeof history.replaceState != "undefined") {
        const baseUrl = window.location.origin;
        let newUrl = "";
        if (type === "admin") {
          newUrl = baseUrl + "/dashboard/" + newPath;
        } else {
          newUrl = baseUrl + "/dashboard/" + newPath + "/?menu=tutor";
        }

        const obj = { Url: newUrl };
        history.replaceState(obj, "", newUrl);
      } else {
        alert("Browser does not support HTML5.");
      }
    }

    handleDesktopLinks() {
      const plugin = this;

      this.elements.userDashboardLinks.each((index, link) => {
        if (plugin.isDesktop()) {
          $(link).on("click", (e) => {
            e.preventDefault();

            const link = $(e.currentTarget).data("link");
            const type = $(e.currentTarget).data("type");
            const formData = new FormData();
            formData.append("action", "load_php_content");
            formData.append("link", link);
            formData.append("type", type);

            $.ajax({
              url: ajax_object.ajax_url,
              type: "POST",
              data: formData,
              processData: false, // Required for FormData
              contentType: false, // Required for FormData
              beforeSend() {
                $(".user-dashboard-transition").addClass("active");
              },
              success: function (response) {
                $(".user-dashboard-desktop-left").html(
                  response.data.pageContent,
                );
                plugin.changeUrl(response.data.pageSlug, type);
                plugin.timer = setTimeout(() => {
                  $(".user-dashboard-transition").removeClass("active");
                }, 2000);
              },
              error: function () {
                console.log("AJAX error");
              },
            });
          });
        }
      });

      clearTimeout(this.timer);
    }

    isDesktop() {
      return window.innerWidth > 1024; // Adjust this value as needed
    }

    handleDashboardMenu() {
      const plugin = this;

      this.elements.userProfileIcon.on("click", function (e) {
        e.preventDefault();

        $(".desktop-header-profile-menu").toggleClass("active");
      });

      $(document).on("click", function (e) {
        // Check if the click was outside the user profile icon and the profile menu
        if (
          !plugin.elements.userProfileIcon.is(e.target) &&
          plugin.elements.userProfileIcon.has(e.target).length === 0 &&
          !$(".desktop-header-profile-menu").is(e.target) &&
          $(".desktop-header-profile-menu").has(e.target).length === 0
        ) {
          $(".desktop-header-profile-menu").removeClass("active");
        }
      });
    }

    handleAccountant() {
      this.elements.userDashboard.on("focus", "#account-IBAN", function () {
        if ($(this).val().substring(0, 3) !== "IR-") {
          $(this).val("IR-");
        }
      });

      this.elements.userDashboard.on("input", "#account-IBAN", function () {
        let inputVal = $(this)
          .val()
          .replace(/[^0-9]/g, ""); // Remove non-numeric characters
        inputVal = "IR-" + inputVal;

        // Format the value as IR-XX-XXXX-XXXX-XXXX-XXXX-XXXX-XX
        let formattedVal = "IR-";
        let sections = [2, 4, 4, 4, 4, 4, 2];
        let currentIndex = 3; // Start after "IR-"
        for (let section of sections) {
          if (inputVal.length > currentIndex) {
            formattedVal +=
              inputVal.substring(currentIndex, currentIndex + section) + "-";
            currentIndex += section;
          }
        }

        // Remove trailing dash if present
        if (formattedVal.endsWith("-")) {
          formattedVal = formattedVal.slice(0, -1);
        }

        // Ensure the input does not exceed the specified length
        if (formattedVal.length > 33) {
          formattedVal = formattedVal.substring(0, 33);
        }

        // Set the formatted value back to the input
        $(this).val(formattedVal);
      });

      this.elements.userDashboard.on(
        "submit",
        ".withdrawal-account-form",
        (e) => {
          e.preventDefault();
          const formData = new FormData(e.currentTarget);
          const accountShaba = $("#account-IBAN").val();
          const shabaPattern =
            /^IR\-\d{2}-\d{4}-\d{4}-\d{4}-\d{4}-\d{4}-\d{2}$/;

          if (!shabaPattern.test(accountShaba)) {
            toast("شناسه شبا اشتباه وارد گردیده", "error");
            return;
          }

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: (response) => {
              toast("اطلاعات باموفقیت بروز گردید.", "success");
              location.href = response.data.url;
            },
            error: (e) => {
              // Handle error
              toast("خطای نامشخص", "error");
            },
          });
        },
      );
    }

    handleFavorites() {
      this.elements.userDashboard.on(
        "click",
        ".favorites-items-wrap a",
        function (e) {
          e.preventDefault();
          console.log(188);

          if ($(this).hasClass("active")) {
            $(this).removeClass("active");
          } else {
            $(this).addClass("active");
          }
        },
      );
    }

    setProfilePicture() {
      const plugin = this;
      const $elements = this.elements;
      // Handle profile picture input change event
      this.elements.userDashboard.on(
        "change",
        "#user_profile_cover_photo_editor #user_photo_dialogue_box",
        function (e) {
          plugin.getImgData($elements.userPicture);
        },
      );
    }

    getImgData(param) {
      const reader = new FileReader();
      try {
        reader.onload = function (e) {
          if (
            $("#user_profile_cover_photo_editor .profile-picture").length > 0
          ) {
            $("#user_profile_cover_photo_editor .profile-picture")[0].src =
              e.target.result;
          } else {
            const img = document.createElement("img");
            img.className = "profile-picture";
            img.src = e.target.result;
            param.find("#user_profile_area").hide();
            param.find(".user-edit-buttons").css("display", "flex");
            $("#user_profile_cover_photo_editor").prepend(img);
          }
        };
        reader.readAsDataURL($("#user_photo_dialogue_box")[0].files[0]);
      } catch (e) {
        return;
      }
    }

    checkUsername() {
      const plugin = this;
      const username = $("#tutor_profile_username").val();
      // Handle Instructor username
      this.elements.userDashboard.on(
        "input",
        ".dashboard-settings-form #tutor_profile_username",
        function (e) {
          const english = /^[A-Za-z0-9]*$/;
          const input = $(this).parent();
          const tempUsername = $(this).val();

          input.find("svg").hide();

          clearTimeout(plugin.timer);
          if (e.target.value.length > 3) {
            if (english.test($(this).val())) {
              plugin.timer = setTimeout(() => {
                if ($(this).val() === username) {
                  $(this).removeClass();
                  return;
                }
                $(this).parent().append('<span class="loader"></span>');
                $.ajax({
                  url: ajax_object.ajax_url,
                  type: "POST",
                  data: {
                    action: "check_username",
                    username: tempUsername,
                  },
                  success: (response) => {
                    // Handle successful upload
                    input.find(".loader").remove();
                    if (response.result.length > 0) {
                      input
                        .find("input")
                        .addClass("rejected")
                        .removeClass("accepted");
                      input.find(".tutor-username-input-reject").show();
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
                      input.find(".tutor-username-input-accept").show();
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
        },
      );
    }

    saveUserMetadata() {
      // Handle form submit
      this.elements.userDashboard.on(
        "submit",
        ".dashboard-settings-form",
        function (e) {
          e.preventDefault();

          let username = "";
          if ($("#tutor_profile_username").hasClass("accepted")) {
            username = $("#tutor_profile_username").val();
          } else if ($("#tutor_profile_username").hasClass("rejected")) {
            toast("لطفا نام کاربری را تغییر داده سپس ذخیره کنید", "error");
            return;
          }

          const userPicture = $(".profile-picture").attr("src");
          const phoneNumber = $("#tutor_profile_phone_number").val();
          const name = $("#tutor_profile_first_name").val();
          const nationalCode = $("#tutor_profile_national_code").val();
          const birthDate = $("#tutor_profile_birth_date").val();
          const education = $("#tutor_profile_education").val();
          const city = $("#tutor_profile_city").val();
          const marriage = $("#tutor_profile_marriage").val();
          const children = $("#tutor_profile_children").val();

          const favs = $(".favorites-items .favorites-items-wrap a.active");
          const favsArr = [];

          if (favs.length > 0) {
            favs.each(function (index, el) {
              favsArr.push($(el).text());
            });
          }

          const phonePattern = new RegExp("^(09[0-9]{2}[0-9]{7})$");

          if (!phonePattern.test(phoneNumber)) {
            toast("شماره را به شکل صحیح وارد کنید", "error");
            return;
          }

          const ajaxCall = $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
              action: "save_user_metadata",
              user_pic: userPicture,
              phone: phoneNumber,
              username: username,
              name: name,
              national_code: nationalCode,
              birth_date: birthDate,
              education: education,
              city: city,
              marriage: marriage,
              children: children,
              favs: favsArr,
            },
            success: (response) => {
              // Handle successful upload
              window.location.href = response.data.url;
              toast(response.data.result, "success");
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        },
      );
    }
  }

  const edumallUserDashboardInit = new EdumallUserDashboard();
})(jQuery);
