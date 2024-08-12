import AWS from "aws-sdk";
import toast from "../toast";
import gsap from "gsap";

(function ($) {
  "use strict";

  class EdumallDashboard {
    constructor() {
      this.elements = {
        userDashboard: $(".user-dashboard"),
        becomeInstructor: $(".become-instructor"),
        storyVideoFile: $(
          ".instructor-story-video #instructor_story_video_file",
        ),
      };

      this.ajaxCall = "";

      this.update(this.elements);
    }

    update($el) {
      const plugin = this;
      let timer = null;
      const username = this.elements.userDashboard
        .find(".instructor-username input")
        .val();

      // Handle Instructor Story
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on("input", ".instructor-story-text textarea", function (e) {
          const story = $(this).val();
          if (story.length < 250) {
            $(".instructor-story-box-limit-start").html(story.length);
          } else {
            $(this).val($(this).val().substring(0, 250));
            if (story.length === 250) {
              $(".instructor-story-box-limit-start").html(story.length);
            }
            return;
          }
        });

      // Handle Instructor username
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on("input", ".instructor-username input", function (e) {
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
                input.append('<span class="loader"></span>');
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
                      input.find(".instructor-username-input-reject").show();
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
                      input.find(".instructor-username-input-accept").show();
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

      // Handle delete tag
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on(
          "click",
          ".instructor-tags-wrap .instructor-tags-wrap-value img",
          function (e) {
            e.preventDefault();
            $(this).parent().remove();
          },
        );

      // Handle delete profile picture button
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on("click", ".user-edit-buttons-delete", function (e) {
          $("#instructor_photo_dialogue_box").val("");
          $("#instructor_profile_cover_photo_editor .profile-picture").attr(
            "src",
            "",
          );
          $("#instructor_profile_area").show();
        });

      // Handle profile picture input change event
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on("change", "#instructor_photo_dialogue_box", function (e) {
          plugin.getImgData(plugin.elements);
        });

      // Handle story buttons
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on("click", ".instructor-story-links a", function (e) {
          e.preventDefault();
          const currentElement = $(this);
          $(`.${currentElement.data("story")}`)
            .addClass("active")
            .siblings()
            .removeClass("active");
          currentElement.addClass("active").siblings().removeClass("active");
        });

      // Handle upload file
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on("change", "#instructor_story_video_file", function (e) {
          plugin.handleFiles(
            e.target.files,
            plugin.formatBytes,
            plugin.uploadFile,
            plugin.updateProgressBar,
          );
        });

      // Handle close button
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on(
          "click",
          ".story-video-upload-close",
          { elements: $el, progress: plugin.updateProgressBar },
          plugin.resetUploadBox,
        );

      // Handle add tags button
      this.elements.userDashboard
        .add(this.elements.becomeInstructor)
        .on("click", ".instructor-tags .instructor-tags-input a", function (e) {
          e.preventDefault();

          const inputValue = $(
            ".instructor-tags .instructor-tags-input input",
          ).val();

          if (inputValue.length >= 2) {
            // Check for duplicate tag
            let isDuplicate = false;
            $(
              ".instructor-tags .instructor-tags-wrap input[type='hidden']",
            ).each(function () {
              if ($(this).val() === inputValue) {
                isDuplicate = true;
                return false; // break out of the loop
              }
            });

            if (!isDuplicate) {
              const tagValue = $("<div>").addClass("instructor-tags-wrap-value")
                .append(`
            <input type="hidden" name='instructor_tags[]' value="${inputValue}">
            <p>${inputValue}</p>
            <img src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgaWQ9InZ1ZXNheC9saW5lYXIvY2xvc2UtY2lyY2xlIj4KPGcgaWQ9ImNsb3NlLWNpcmNsZSI+CjxwYXRoIGlkPSJWZWN0b3IiIGQ9Ik0xMiAyMkMxNy41IDIyIDIyIDE3LjUgMjIgMTJDMjIgNi41IDE3LjUgMiAxMiAyQzYuNSAyIDIgNi41IDIgMTJDMiAxNy41IDYuNSAyMiAxMiAyMloiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMiIgZD0iTTkuMTY5OTIgMTQuODI5OUwxNC44Mjk5IDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMyIgZD0iTTE0LjgyOTkgMTQuODI5OUw5LjE2OTkyIDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjwvZz4KPC9nPgo8L3N2Zz4K'/>`);

              $(".instructor-tags .instructor-tags-wrap").append(tagValue);
            }

            $(".instructor-tags .instructor-tags-input input").val("");
          }
        });

      // Handle form submit
      this.elements.userDashboard.on(
        "submit",
        ".instructor-settings-form",
        function (e) {
          e.preventDefault();

          if ($("#instructor_profile_username").hasClass("rejected")) {
            toast("لطفا نام کاربری را تغییر داده سپس ذخیره کنید", "error");
            return;
          }

          const formData = new FormData(this);

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: (response) => {
              // Handle successful upload
              toast(response.result, "success");
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        },
      );

      this.elements.becomeInstructor.on(
        "submit",
        ".become-instructor-form",
        function (e) {
          e.preventDefault();

          if ($("#instructor_profile_username").hasClass("rejected")) {
            toast("لطفا نام کاربری را تغییر داده سپس ذخیره کنید", "error");
            return;
          }

          const formData = new FormData(this);

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: (response) => {
              // Handle successful upload
              toast(response.result, "success");
              location.href = response.url;
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        },
      );
    }

    resetUploadBox($el, updateProgressBar, ajaxCall) {
      ajaxCall ? ajaxCall.abort() : "";
      $(".instructor-story-video .story-video").css("display", "flex");
      $(".instructor-story-video .story-video-upload").hide();
      $(".story-video-upload-progress .progress").css(
        "background-color",
        "#015372",
      );
      if ($el.data) {
        $("#instructor_story_video_file").val("");
        $el.data.progress(0);
      } else {
        $("#instructor_story_video_file").val("");
        updateProgressBar(0);
      }
    }

    getImgData($el) {
      const reader = new FileReader();
      try {
        reader.onload = function (e) {
          if (
            $("#instructor_profile_cover_photo_editor .profile-picture")
              .length > 0
          ) {
            $(
              "#instructor_profile_cover_photo_editor .profile-picture",
            )[0].src = e.target.result;
            $("#instructor-picture").val(e.target.result);
          } else {
            const img = document.createElement("img");
            img.className = "profile-picture";
            img.src = e.target.result;
            $("#instructor_profile_area").hide();
            $(".user-edit-buttons").css("display", "flex");
            $("#instructor_profile_cover_photo_editor").prepend(img);
            $("#instructor-picture").val(e.target.result);
          }
        };
        reader.readAsDataURL($("#instructor_photo_dialogue_box")[0].files[0]);
      } catch (e) {
        return;
      }
    }

    handleFiles(files, formatBytes, uploadFile, progressBar) {
      const maxFileSize = 200;

      if (files.length > 0) {
        const file = files[0];
        // Check if the file size exceeds the maximum allowed size
        if (file.size > maxFileSize * 1024 * 1024) {
          toast("اندازه فایل از " + maxFileSize + "MB بیشتر است", "error");
          // Clear the file input
          $("#instructor_story_video_file").val("");
          return;
        }

        // Check if the file has the correct extension
        if (!file.name.toLowerCase().endsWith(".mp4")) {
          toast("فقط فایل با پسوند .mp4 مجاز است", "error");
          // Clear the file input
          $("#file-input").val("");
          return;
        }

        // Display file information
        $(".instructor-story-video .story-video").hide();
        $(".instructor-story-video .story-video-upload").css("display", "flex");
        $(".instructor-story-video .story-video-upload #file-name").text(
          file.name,
        );
        $(".instructor-story-video .story-video-upload #file-size").text(
          formatBytes(file.size),
        );

        // Display progress bar
        uploadFile(file, progressBar);
      }
    }

    // Function to format bytes into a readable format
    formatBytes(bytes, decimals = 2) {
      if (bytes === 0) return "0 Bytes";

      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

      const i = Math.floor(Math.log(bytes) / Math.log(k));

      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + " " + sizes[i];
    }

    // Function to update progress bar and text
    uploadFile(file, updateProgressBar) {
      const user_id = $(".instructor-settings")
        ? $(".instructor-settings").data("user")
        : $(".become-instructor").data("user");

      // Configure AWS SDK with your credentials
      AWS.config.update({
        accessKeyId: "9bad323b-38bf-451e-a224-c999cf54719b",
        secretAccessKey:
          "0f1ac9754be7930756b1db0f05cea93ae289d3b64203e24b35aa9813ee4ae21d",
        region: "ir-thr-at1",
        endpoint: "https://s3.ir-thr-at1.arvanstorage.ir",
      });
      var s3 = new AWS.S3();
      // Set the bucket name
      var bucketName = "hanil";
      // Prepare the params for uploading
      var params = {
        Bucket: bucketName,
        Key: "user_" + user_id + "_story.mp4",
        Body: file,
        ACL: "public-read", // Optional - Set permissions on the uploaded file
      };
      // Upload the file to S3
      var upload = s3.upload(params);
      // Listen for upload progress
      upload.on("httpUploadProgress", function (progress) {
        var uploaded = progress.loaded;
        var total = progress.total;
        var percent = Math.round((uploaded / total) * 100);
        // Update UI with upload progress
        updateProgressBar(percent);
      });
      // Perform actions after upload completion
      upload.send(function (err, data) {
        if (err) {
          console.log(err, err.stack);
        } else {
          toast("فایل با موفقیت آپلود شد", "success");
          $(".story-video-upload-progress .progress").css(
            "background-color",
            "#1DAB45",
          );
          // Optionally, perform actions after successful upload
        }
      });
    }

    // Function to update progress bar and text
    updateProgressBar(percentComplete) {
      $(".story-video-upload-progress .progress").css(
        "width",
        percentComplete + "%",
      );
      $(".story-video-upload-progress .progress-text").text(
        Math.round(percentComplete) + "%",
      );
    }
  }

  const edumallDashboardInit = new EdumallDashboard();
})(jQuery);
