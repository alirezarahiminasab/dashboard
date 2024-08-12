import toast from "../toast";

(function ($) {
  "use strict";

  let chapterWrap = $(".course-create-chapter:last").clone();
  chapterWrap.find(".course-create-chapter-lesson").slice(1).remove();
  chapterWrap.find("input").val("");
  chapterWrap.find("label").addClass("active");
  chapterWrap.find(".course-create-video-uploaded").removeClass("active");
  chapterWrap.find("video").attr("src", "");
  const questionBox = $(".course-create-questions-input").clone();

  class EdumallCreateCourse {
    constructor() {
      this.elements = {
        courseInputCounter: $(".course-create-input"),
        courseCreateGoals: $(".course-create-goals"),
        courseTopic: $("#course-create-topic"),
        coursePrerequisites: $(".course-create-prerequisites"),
        courseChapters: $(".course-create-lessons"),
        courseQuestions: $(".course-create-questions"),
        courseTags: $(".course-create-tags"),
        courseSubmit: $(".course-create-submit"),
      };

      this.timer = null;

      this.handleInputCounter();
      this.handleCover();
      this.handleTags();
      this.handleCreateGoals();
      this.handleInputPrice();
      this.handleCoursePrerequisite();
      this.handleChapter();
      this.handleQuestions();
      this.handleSubmit();
    }

    handleInputCounter() {
      this.elements.courseInputCounter.on("input", function (e) {
        const story = $(this).val();
        const limit = $(this).data("limit");

        if (story.length < limit) {
          $(this)
            .siblings("span")
            .find(".course-create-counter-limit")
            .html(story.length);
        } else {
          $(this).val($(this).val().substring(0, limit));
          if (story.length === limit) {
            $(this)
              .siblings("span")
              .find(".course-create-counter-limit")
              .html(story.length);
          }
          return;
        }
      });
    }

    handleCover() {
      this.elements.courseTopic.on(
        "change",
        "#course-create-cover",
        (event) => {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
              $(".course-create-cover-uploaded-file").attr(
                "src",
                e.target.result,
              );

              $(".course-create-cover-input").removeClass("active");
              $(".course-create-cover-uploaded").addClass("active");
            };
            reader.readAsDataURL(file);
          }
        },
      );

      this.elements.courseTopic.on(
        "click",
        ".course-create-cover-uploaded a",
        (e) => {
          e.preventDefault();

          // Clear the file input and remove the uploaded image
          $(".course-create-cover-uploaded-file").attr("src", "");
          $("#course-create-cover").val("");
          $(".course-create-cover-input").addClass("active");
          $(".course-create-cover-uploaded").removeClass("active");
        },
      );
    }

    handleTags() {
      this.elements.courseTags.on(
        "change",
        ".course-create-tags-dropdown",
        function () {
          const tagItems = $(".course-create-tags-list span");
          if (tagItems.length < 5) {
            const selectedOption = $(this).find("option:selected");
            const tagName = $(this).find("option:selected").data("name");

            selectedOption.remove();
            $(".course-create-tags-list").append(`<span>
              <input type="hidden" name='course-create-tags[]' value="${tagName}">
              <p>${tagName}</p>
              <svg class='course-create-tag-delete' width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path id="Vector" d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
              <path id="Vector_2" d="M9.16992 14.8299L14.8299 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
              <path id="Vector_3" d="M14.8299 14.8299L9.16992 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              </span>`);
          }
        },
      );

      this.elements.courseTags.on(
        "click",
        ".course-create-tag-delete",
        function () {
          const tagValue = $(this).siblings("p").text();
          $(".course-create-tags-dropdown").append(`
           <option value="${tagValue}">
              ${tagValue}
           </option>          
          `);
          $(this).parent().remove();
        },
      );
    }

    handleCreateGoals() {
      this.elements.courseCreateGoals.find("a").on("click", function (e) {
        e.preventDefault();
        const $counter = $(".course-create-goals-wrap input:last").attr(
          "data-counter",
        );
        const $goalInput = $("#course-create-goals").clone();
        $goalInput.val("");
        $goalInput.attr("data-counter", parseInt($counter) + 1);
        $(".course-create-goals-wrap").append($goalInput);
      });
    }

    handleInputPrice() {
      $("#course-create-price-input").on("input", function (e) {
        var value = $(this).val();
        value = value.replace(/\D/g, ""); // Remove any non-digit characters
        if (value) {
          value = parseInt(value, 10).toLocaleString(); // Convert to integer and format with thousands separator
        }
        $(this).val(value);
      });
    }

    handleCoursePrerequisite() {
      this.elements.coursePrerequisites.on("input", function () {
        const coursePreName = $(this).val();
        const inputCoursePre = this;

        if (coursePreName.length > 3) {
          const existCoursePre = $(".course-create-pre-list span p");
          const existCourseArr = [];

          existCoursePre.each(function (index, item) {
            existCourseArr.push($(item).data("id"));
          });

          const formData = new FormData();
          formData.append("action", "get_courses_prerequisites");
          formData.append("courseName", coursePreName);
          formData.append("existCourse", existCourseArr);

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            beforeSend() {
              $(".course-create-pre-dropdown").html("");
              $(".course-create-pre-wrap-input").append(
                "<span class='loader'></span>",
              );
            },
            success: function (response) {
              $(".course-create-pre-wrap-input .loader").remove();
              if (response.success) {
                $(".course-create-pre-dropdown").addClass("active");
                const courses = response.data.courses;

                courses.map(function (item) {
                  $(".course-create-pre-dropdown").append(
                    `<a class='course-create-pre-item' href='#' data-id='${
                      item.ID
                    }'>${decodeURIComponent(item.post_name)}</a>`,
                  );
                });
              }

              // Event delegation for dynamically added elements
              $(".course-create-pre-dropdown")
                .off("click")
                .on("click", ".course-create-pre-item", function (e) {
                  e.preventDefault();
                  const courseName = $(this).text();
                  const courseID = $(this).data("id");

                  $(".course-create-pre-dropdown").removeClass("active");
                  $(".course-create-pre-list").addClass("active");
                  $(".course-create-pre-list").append(`<span>
          <p data-id='${courseID}'>${courseName}</p>
          <svg class='course-create-pre-delete' width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path id="Vector" d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
              <path id="Vector_2" d="M9.16992 14.8299L14.8299 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
              <path id="Vector_3" d="M14.8299 14.8299L9.16992 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
      </span>`);
                });

              // Event delegation for dynamically added delete buttons
              $(".course-create-pre-list")
                .off("click")
                .on("click", ".course-create-pre-delete", function (e) {
                  e.preventDefault();
                  $(this).parent().remove();
                });
            },
            error: function (response) {
              console.error(response);
            },
          });
        }
      });
    }

    handleChapter() {
      this.elements.courseChapters.on(
        "click",
        ".course-create-add-lesson a",
        function (e) {
          e.preventDefault();

          const lessonWrap = $(this)
            .parent()
            .siblings(".course-create-chapter-lesson:last")
            .clone();
          const lessonCounter = lessonWrap.attr("data-lesson");
          const chapterCounter = $(this).parent().parent().attr("data-chapter");

          lessonWrap.find("#chapter-title").parent().remove();
          lessonWrap
            .find(".course-create-video-progress")
            .removeClass("active");
          lessonWrap
            .find(".course-create-video")
            .attr(
              "id",
              `course-create-video-${parseInt(chapterCounter)}-${
                parseInt(lessonCounter) + 1
              }`,
            );
          lessonWrap.find("input").val("");
          lessonWrap
            .find(".course-create-chapter-lesson-video-input")
            .attr(
              "for",
              `course-create-video-${parseInt(chapterCounter)}-${
                parseInt(lessonCounter) + 1
              }`,
            );

          lessonWrap
            .find("#lesson-title")
            .parent()
            .siblings("label")
            .text(`عنوان قسمت ${parseInt(lessonCounter) + 1}`);
          lessonWrap
            .find("#lesson-description")
            .siblings("label")
            .text(`توضیحات متنی قسمت ${parseInt(lessonCounter) + 1}`);
          lessonWrap.addClass("appended-lesson");
          lessonWrap.attr("data-lesson", parseInt(lessonCounter) + 1);

          $(lessonWrap)
            .find(".course-create-chapter-lesson-video-input")
            .addClass("active");
          $(lessonWrap)
            .find(".course-create-video-uploaded")
            .removeClass("active");

          $(lessonWrap)
            .find(".course-create-video-uploaded video")
            .attr("src", "");

          $(this).parent().before(lessonWrap);
        },
      );

      this.elements.courseChapters.on(
        "click",
        ".course-create-add-chapter a",
        function (e) {
          e.preventDefault();

          const chapterCounter = chapterWrap.attr("data-chapter");

          chapterWrap
            .find(".course-create-video")
            .attr(
              "id",
              `course-create-video-${parseInt(chapterCounter) + 1}-1`,
            );
          chapterWrap
            .find(".course-create-chapter-lesson-video-input")
            .attr(
              "for",
              `course-create-video-${parseInt(chapterCounter) + 1}-1`,
            );
          chapterWrap
            .find(".course-create-chapter-input label")
            .html(`عنوان فصل ${parseInt(chapterCounter) + 1}<sup>*</sup>`);

          chapterWrap
            .find(".course-create-chapter-counter p")
            .text(`فصل ${parseInt(chapterCounter) + 1}`);

          chapterWrap.attr("data-chapter", parseInt(chapterCounter) + 1);

          $(".course-create-add-chapter").before(chapterWrap.clone());
        },
      );

      this.elements.courseChapters.on(
        "change",
        ".course-create-video",
        function (e) {
          const file = e.target.files[0];
          if (file) {
            const blobURL = URL.createObjectURL(file);

            $(this).siblings("label").removeClass("active");
            $(this)
              .siblings(".course-create-video-uploaded")
              .addClass("active");

            $(this)
              .siblings(".course-create-video-uploaded")
              .find("video")
              .attr("src", blobURL);
          }
        },
      );

      this.elements.courseChapters.on(
        "click",
        ".course-create-video-uploaded a",
        (e) => {
          e.preventDefault();

          // Clear the file input and remove the uploaded image
          $(e.currentTarget).siblings("video").attr("src", "");
          $(e.currentTarget).parent().siblings(".course-create-video").val("");
          $(e.currentTarget)
            .parent()
            .siblings(".course-create-chapter-lesson-video-input")
            .addClass("active");
          $(e.currentTarget).parent().removeClass("active");
        },
      );
    }

    handleQuestions() {
      this.elements.courseQuestions.on(
        "click",
        ".course-create-questions-add a",
        function (e) {
          e.preventDefault();

          $(".course-create-questions-add").before(questionBox.clone());
        },
      );

      this.elements.courseQuestions.on("input", "input,textarea", function (e) {
        if ($(this).val().trim() !== "") {
          $(this).addClass("not-empty");
        } else {
          $(this).removeClass("not-empty");
        }
      });
    }

    handleSubmit() {
      const plugin = this;

      this.elements.courseSubmit.on(
        "click",
        ".course-create-submit-check input",
        function (e) {
          $(".course-create-submit-btn button").prop("disabled", !this.checked);
        },
      );

      $(".course-create-form").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: formData,
          processData: false, // Required for FormData
          contentType: false, // Required for FormData
          beforeSend() {
            $(".course-create-submit-btn button").prop("disabled", true);
          },
          success(response) {
            if (response.success) {
              const lessonID = response.data.lesson_id;
              const files = $(".course-create-video");
              const videos = $(".course-create-video-uploaded video");
              const redirectUrl = response.data.url;
              console.log(files);
              plugin.uploadFilesSequentially(
                files,
                videos,
                lessonID,
                redirectUrl,
              );
            }
          },
        });
      });
    }

    uploadFilesSequentially(files, videos, lessonID, redirectUrl) {
      const plugin = this;

      function uploadNext(index) {
        if (index >= files.length) {
          // All files uploaded, redirect to the provided URL
          location.href = redirectUrl;
          return;
        }

        console.log(files[index].files[0]);
        if (Boolean(files[index].files[0])) {
          let fileInput = files[index];
          let file = fileInput.files[0];
          let name = $(fileInput).attr("id");

          const videoDuration = plugin.calculateVideoDuration($(videos[index]));
          $(fileInput)
            .siblings(".course-create-video-uploaded")
            .removeClass("active");
          $(fileInput)
            .siblings(".course-create-video-progress")
            .addClass("active");

          plugin
            .uploadFile(file, lessonID[index], name, videoDuration, fileInput)
            .then(() => {
              // Upload the next file after the current one is finished
              uploadNext(index + 1);
            })
            .catch((error) => {
              console.error("File upload failed", error);
              // Handle error and possibly break the upload sequence
            });
        } else {
          // No file to upload, skip to the next one
          uploadNext(index + 1);
        }
      }

      // Start uploading from the first file
      uploadNext(0);
    }

    uploadFile(file, lessonID, name, videoDuration, fileInput) {
      return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        $(fileInput)
          .siblings(".course-create-video-progress")
          .find(".video-name")
          .text(file.name);
        $(fileInput)
          .siblings(".course-create-video-progress")
          .find(".video-size")
          .text(this.formatBytes(file.size));

        const successMessageContainer = $("<div>", {
          class: "course-create-video-success",
        });

        const successMessage = $("<p>", {
          text: "فایل با موفقیت آپلود شد.",
        });
        successMessageContainer.append(successMessage);

        const errorMessageContainer = $("<div>", {
          class: "course-create-video-error",
        });
        const errorMessage = $("<p>", {
          text: "فایل آپلود نشد.",
        });

        errorMessageContainer.append(errorMessage);

        let progressBar = $(fileInput).siblings(
          ".course-create-video-progress",
        );

        let progress = progressBar.find(".progress-bar-ribbon div");
        let percentage = progressBar.find(".progress-bar-percentage p");

        xhr.upload.addEventListener("progress", function (e) {
          if (e.lengthComputable) {
            let percentComplete = (e.loaded / e.total) * 100;
            progress.css("width", percentComplete + "%");
            percentage.text(Math.round(percentComplete) + "%");
          }
        });

        xhr.upload.addEventListener("load", function (e) {
          progress.css("width", "100%");
          percentage.text("100%");
        });

        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4) {
            if (xhr.status == 200) {
              let response = JSON.parse(xhr.responseText);
              if (response.success) {
                progressBar
                  .find(".course-create-video-progress-bar")
                  .html(successMessageContainer);
                resolve();
              } else {
                progressBar
                  .find(".course-create-video-progress-bar")
                  .html(errorMessageContainer);
                reject(new Error("Upload failed"));
              }
            } else {
              reject(new Error("XHR request failed"));
            }
          }
        };

        xhr.open("POST", ajax_object.ajax_url);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

        let fileData = new FormData();
        fileData.append("file", file);
        fileData.append("lesson_id", lessonID);
        fileData.append("lesson_video_name", name);
        fileData.append("lesson_video_duration", JSON.stringify(videoDuration));
        fileData.append("action", "create_lesson_video");
        fileData.append("_tutor_nonce", $("#_tutor_nonce").val());

        // xhr.send(fileData);
      });
    }

    formatBytes(bytes, decimals = 2) {
      if (bytes === 0) return "0 Bytes";

      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

      const i = Math.floor(Math.log(bytes) / Math.log(k));

      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + " " + sizes[i];
    }

    calculateVideoDuration(video) {
      const duration = video[0].duration; // Duration in seconds

      // Convert the duration to hours, minutes, and seconds
      const hours = Math.floor(duration / 3600);
      const minutes = Math.floor((duration % 3600) / 60);
      const seconds = Math.floor(duration % 60);

      return {
        hours: hours.toString().padStart(2, "0"),
        minutes: minutes.toString().padStart(2, "0"),
        seconds: seconds.toString().padStart(2, "0"),
      };
    }
  }

  const edumallCreateCourseInit = new EdumallCreateCourse();
})(jQuery);
