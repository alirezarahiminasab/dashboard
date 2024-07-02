import toast from "../toast";
import gsap from "gsap";

(function ($) {
  "use strict";

  class EdumallUserDashboard {
    constructor() {
      this.elements = {
        userForm: $(".dashboard-settings-form"),
        userPicture: $("#user_profile_cover_photo_editor"),
        userAccountant: $(".withdrawal-account-form"),
      };

      this.timer = null;

      this.setProfilePicture();
      this.saveUserMetadata();
      this.checkUsername();
      this.handleFavorites();
      this.handleAccountant();
    }

    handleAccountant() {
      this.elements.userAccountant.on("submit", (e) => {
        e.preventDefault();
        const userID = $("#user-id").data("user-id");
        const bankName = $("#bank-name").val();
        const accountNumber = $("#account-number").val();
        const accountShaba = $("#account-shaba").val();
        const accountFirstName = $("#account-first-name").val();
        const accountLastName = $("#account-last-name").val();
        const accountDepositID = $("#account-deposit-id").val();

        const shabaPattern = /^\d{2}-\d{4}-\d{4}-\d{4}-\d{4}-\d{4}-\d{2}$/;

        if (!shabaPattern.test(accountShaba)) {
          toast("شناسه شبا اشتباه وارد گردیده", "error");
          return;
        }

        $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "save_user_accountant",
            userID: userID,
            bankName: bankName,
            accountNumber: accountNumber,
            accountShaba: accountShaba,
            accountFirstName: accountFirstName,
            accountLastName: accountLastName,
            accountDepositID: accountDepositID,
          },
          success: (response) => {
            toast("اطلاعات باموفقیت بروز گردید.", "success");
          },
          error: (e) => {
            // Handle error
            toast("خطای نامشخص", "error");
          },
        });
      });
    }

    handleFavorites() {
      this.elements.userForm
        .find(".favorites-items-wrap a")
        .on("click", function (e) {
          e.preventDefault();

          if ($(this).hasClass("active")) {
            $(this).removeClass("active");
          } else {
            $(this).addClass("active");
          }
        });
    }

    setProfilePicture() {
      const plugin = this;
      const $elements = this.elements;
      // Handle profile picture input change event
      this.elements.userPicture
        .find("#user_photo_dialogue_box")
        .on("change", function (e) {
          plugin.getImgData($elements.userPicture);
        });
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
      this.elements.userForm
        .find("#tutor_profile_username")
        .on("input", function (e) {
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
        });
    }

    saveUserMetadata() {
      // Handle form submit
      this.elements.userForm.on("submit", function (e) {
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

        var phonePattern = new RegExp("^(09[0-9]{2}[0-9]{7})$");

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
      });
    }
  }

  const edumallUserDashboardInit = new EdumallUserDashboard();
})(jQuery);
