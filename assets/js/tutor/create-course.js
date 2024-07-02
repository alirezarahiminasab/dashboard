import toast from "../toast";
import gsap from "gsap";

(function ($) {
  "use strict";

  let chapterWrap = $(".course-create-chapter:last").clone();
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
            const tagValue = $(this).val();
            const selectedOption = $(this).find("option:selected");
            selectedOption.remove();
            $(".course-create-tags-list").append(`<span>
              <p>${decodeURIComponent(tagValue)}</p>
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

          lessonWrap.find("#chapter-title").parent().remove();
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
            .find(".course-create-chapter-counter p")
            .text(`فصل ${parseInt(chapterCounter) + 1}`);

          chapterWrap.attr("data-chapter", parseInt(chapterCounter) + 1);

          $(".course-create-add-chapter").before(chapterWrap.clone());
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
      this.elements.courseSubmit.on(
        "click",
        ".course-create-submit-check input",
        function (e) {
          $(".course-create-submit-btn button").prop("disabled", !this.checked);
        },
      );

      $(".course-create-form").on("submit", function (e) {
        e.preventDefault();
        console.log(239);
      });
    }
  }

  const edumallCreateCourseInit = new EdumallCreateCourse();
})(jQuery);
