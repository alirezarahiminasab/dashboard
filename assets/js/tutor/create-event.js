import toast from "../toast";
import gsap from "gsap";
// import moment from "moment";
import moment from "moment-jalaali";

(function ($) {
  "use strict";

  let chapterWrap = $(".course-create-chapter:last").clone();
  const questionBox = $(".course-create-questions-input").clone();

  class CardManager {
    constructor() {
      this.cards = [];
    }

    addCard(card) {
      card.id = this.cards.length + 1;
      this.cards.push(card);
      return card.id;
    }

    updateCard(id, updatedCard) {
      const index = this.cards.findIndex((card) => card.id === id);
      if (index !== -1) {
        this.cards[index] = { ...this.cards[index], ...updatedCard };
      }
    }

    deleteCard(id) {
      this.cards = this.cards.filter((card) => card.id !== id);
    }

    getCard(id) {
      return this.cards.find((card) => card.id === id);
    }

    getAllCards() {
      return this.cards;
    }
  }

  class EdumallCreateEvent {
    constructor() {
      this.companionLogoImage = {};
      this.coverImage = {};
      this.tags = [];
      this.elements = {
        eventInputCounter: $(".event-create-input"),
        eventCreateGoals: $(".event-create-goals"),
        eventTopic: $("#event-create-topic"),
        eventPrerequisites: $(".event-create-prerequisites"),
        eventChapters: $(".event-create-lessons"),
        eventQuestions: $(".event-create-questions"),
        eventTags: $(".event-create-tags"),
        eventSubmit: $(".event-create-submit"),
        eventInputTime: $(".input-time"),
        eventSessions: $(".event-create-sessions"),
        eventSessionsForm: $(".event-create-sessions-form"),
        eventSessionsFull: $(".event-create-sessions-full"),
        eventCompanions: $(".event-create-companions"),
        eventCompanionsForm: $(".event-create-companions-form"),
        eventCompanionsFull: $(".event-create-companions-full"),
        eventTickets: $(".event-create-tickets"),
        eventTicketsFull: $(".event-create-tickets-full"),
      };

      this.timer = null;

      this.handleInputCounter();
      this.handleCover();
      this.handleLogo();
      this.handleTags();
      this.handleCreateGoals();
      this.handleInputPrice();
      this.handleeventPrerequisite();
      this.handleChapter();
      this.handleQuestions();
      this.handleSubmit();
      // this.handleInputTime();
      this.handleSessions();
      this.handleCompanions();
      this.handleTickets();
      this.handleDatePicker();
      this.eventCreateAjax();
    }

    eventCreateAjax() {
      // formData.append("action", "test");
      // formData.append(
      //   "data",
      //   array(
      //     (a) => "123",
      //     (b) => "xsadc"
      //   )
      // );

      const _this = this;
      $("#event-create-form").on("submit", function () {
        const formData = new FormData(this);

        const _formData = $(this).serializeArray();

        // _formData.forEach(function (field) {
        //   console.log(field.name + ": " + field.value);
        // });
        const field = (name) => _formData.find((x) => x.name === name).value;
        const dateTime2unix = (date) =>
          date ? moment(date, "jYYYY-jMM-jDD HH:mm").unix() : date;

        formData.append(
          "event-create-start-dateTime",
          dateTime2unix(
            `${field("event-create-start-date")} ${field(
              "event-create-start-time"
            )}`
          )
        );

        formData.append(
          "event-create-finish-dateTime",
          dateTime2unix(
            `${field("event-create-finish-date")} ${field(
              "event-create-finish-time"
            )}`
          )
        );

        formData.append(
          "event-create-session-start-dateTime",
          dateTime2unix(
            `${field("event-create-session-date")} ${field(
              "event-create-session-start-time"
            )}`
          )
        );

        formData.append(
          "event-create-session-finish-dateTime",
          dateTime2unix(
            `${field("event-create-session-date")} ${field(
              "event-create-session-finish-time"
            )}`
          )
        );

        formData.append(
          "event-create-sale-start-dateTime",
          dateTime2unix("event-create-sale-start-date")
        );

        formData.append(
          "event-create-sale-finish-dateTime",
          dateTime2unix("event-create-sale-finish-date")
        );

        // formData.append("action", "create_event");
        formData.append("event-create-tags", _this.tags.join("-"));

        if (_this.companionLogoImage.data) {
          formData.append(
            "event-create-companion-logo-data",
            _this.companionLogoImage.data
          );

          formData.append(
            "event-create-companion-logo-fileName",
            _this.companionLogoImage.fileName
          );
        }

        if (_this.coverImage.data) {
          formData.append("event-create-cover-data", _this.coverImage.data);

          formData.append(
            "event-create-cover-fileName",
            _this.coverImage.fileName
          );
        }

        $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: formData,
          processData: false, // Required for FormData
          contentType: false, // Required for FormData
          beforeSend() {
            // $(".event-create-pre-dropdown").html("");
            // $(".event-create-pre-wrap-input").append(
            //   "<span class='loader'></span>"
            // );
          },
          success: function (response) {
            console.log(response);
            // $(".event-create-pre-wrap-input .loader").remove();
            // if (response.success) {
            //   $(".event-create-pre-dropdown").addClass("active");
            //   const events = response.data.events;

            //   events.map(function (item) {
            //     $(".event-create-pre-dropdown").append(
            //       `<a class='event-create-pre-item' href='#' data-id='${
            //         item.ID
            //       }'>${decodeURIComponent(item.post_name)}</a>`
            //     );
            //   });
            // }
          },
          error: function (response) {
            console.error(response);
          },
        });
      });
    }

    handleDatePicker() {
      jalaliDatepicker.startWatch({
        time: true,
        // date: false,
        hasSecond: false,
        // persianDigits: true,
        plusHtml: "&#11166;",
        minusHtml: "&#11164;",
        showEmptyBtn: false,
        // showCloseBtn: false,
      });
    }

    // TODO

    setActiveSection(sectionName) {
      const sections = [
        "eventSessions",
        "eventSessionsForm",
        "eventSessionsFull",
        "eventCompanions",
        "eventCompanionsForm",
        "eventCompanionsFull",
        "eventTickets",
        "eventTicketsFull",
      ];
      sections.forEach((section) => {
        this.elements[section].removeClass("active");
      });
      this.elements[sectionName].addClass("active");
    }

    addSessionCard() {
      // Get form values
      const sessionFull = this.elements.eventSessionsFull;
      const sessionForm = this.elements.eventSessionsForm;

      const sessionTitleValue = sessionForm
        .find(`[name="event-create-session-title"]`)
        .val();
      const sessionPlatformValue = sessionForm
        .find(`[name="event-create-platform"]`)
        .val();
      const sessionDateValue = sessionForm
        .find(`[name="event-create-session-date"]`)
        .val();
      const sessionStartTimeValue = sessionForm
        .find(`[name="event-create-session-start-time"]`)
        .val();
      const sessionFinishTimeValue = sessionForm
        .find(`[name="event-create-session-finish-time"]`)
        .val();

      // Create card element
      const card = $(`
            <div class="card-type1">
                <div class="flex justify-between p-3">
                    <p ref="event-create-session-title">${sessionTitleValue}</p>
                    <span>
                        <img class="h-fit" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                        <img class="h-fit" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                    </span>
                </div>
                <div class="more">
                    <div class="column">
                        <span>
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/3d-cube-scan.png'?>" alt="">
                            <p ref="event-create-session-platform">${sessionPlatformValue}</p>
                        </span>
                        <span>
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/toggle-off-circle.png'?>" alt="">
                            <p>فعال</p>
                        </span>
                    </div>
                    <div class="column">
                        <span>
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                            <p ref="event-create-session-start-date">${sessionDateValue} - ${sessionStartTimeValue}</p>
                        </span>
                        <span>
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                            <p ref="event-create-session-finish-date">${sessionDateValue} - ${sessionFinishTimeValue}</p>
                        </span>
                    </div>
                </div>
            </div>
        `);

      // Append card to the sessions full div
      // $(".event-create-section-inner.event-create-sessions-full").append(card);
      sessionFull.append(card);
    }

    handleSessions() {
      const createSession = this.elements.eventSessions;
      const sessionForm = this.elements.eventSessionsForm;
      const sessionFull = this.elements.eventSessionsFull;

      // const sessionTitle = sessionFull.find(
      //   `[ref="event-create-session-title"]`
      // );
      // const sessionPlatform = sessionFull.find(
      //   `[ref="event-create-session-platform"]`
      // );
      // const sessionStartDate = sessionFull.find(
      //   `[ref="event-create-session-start-date"]`
      // );
      // const sessionFinishDate = sessionFull.find(
      //   `[ref="event-create-session-finish-date"]`
      // );

      // sessionForm.find(`[name="event-create-session-title"]`).val();
      // sessionForm.find(`[name="event-create-platform"]`).val();
      // sessionForm.find(`[name="event-create-session-date"]`).val();
      // sessionForm.find(`[name="event-create-session-start-time"]`).val();
      // sessionForm.find(`[name="event-create-session-finish-time"]`).val();

      createSession.on("click", ".event-create-extract-content", function () {
        createSession.removeClass("active");
        sessionFull.removeClass("active");
        sessionForm.addClass("active");
      });

      sessionFull.on("click", ".event-create-add-content", function () {
        createSession.removeClass("active");
        sessionFull.removeClass("active");
        sessionForm.addClass("active");
      });

      const _this = this;
      sessionForm.on("click", ".btn-submit", function () {
        _this.addSessionCard();
        // sessionTitle.val(
        //   sessionFull.find(`[name="event-create-session-title"]`).val()
        // );
        // sessionPlatform.val(
        //   sessionFull.find(`[name="event-create-platform"]`).val()
        // );
        // sessionStartDate.val(
        //   sessionFull.find(`[name="event-create-session-start-date"]`).val()
        // );
        // sessionFinishDate.val(
        //   sessionFull.find(`[name="event-create-session-finish-date"]`).val()
        // );

        sessionForm.removeClass("active");
        sessionFull.addClass("active");
        createSession.removeClass("active");
      });

      sessionForm.on("click", ".btn-cancel", function () {
        sessionForm.removeClass("active");
        sessionFull.removeClass("active");
        createSession.addClass("active");
      });
    }

    handleCompanions() {
      const createCompanion = this.elements.eventCompanions;
      const companionForm = this.elements.eventCompanionsForm;
      const companionFull = this.elements.eventCompanionsFull;

      createCompanion.on("click", ".event-create-extract-content", function () {
        createCompanion.removeClass("active");
        companionFull.removeClass("active");
        companionForm.addClass("active");
      });

      companionFull.on("click", ".event-create-add-content", function () {
        createCompanion.removeClass("active");
        companionFull.removeClass("active");
        companionForm.addClass("active");
      });

      companionForm.on("click", ".btn-submit", function () {
        companionForm.removeClass("active");
        companionFull.addClass("active");
        createCompanion.removeClass("active");
      });

      companionForm.on("click", ".btn-cancel", function () {
        companionForm.removeClass("active");
        companionFull.removeClass("active");
        createCompanion.addClass("active");
      });
    }

    handleTickets() {
      const createTicket = this.elements.eventTickets;
      const ticketFull = this.elements.eventTicketsFull;

      ticketFull.on("click", ".event-create-add-content", function () {
        createTicket.addClass("active");
        ticketFull.removeClass("active");
      });

      createTicket.on("click", ".btn-submit", function () {
        ticketFull.addClass("active");
        createTicket.removeClass("active");
      });

      createTicket.on("click", ".btn-cancel", function () {
        ticketFull.addClass("active");
        createTicket.removeClass("active");
      });
    }

    handleInputTime() {
      this.elements.eventInputTime.on("input", function () {
        let value = $(this).val().replace(/\D/g, ""); // Remove non-numeric characters
        if (value.length > 4) value = value.slice(0, 4); // Limit to 4 digits

        if (value.length > 2) {
          value = value.slice(0, 2) + ":" + value.slice(2);
        }

        $(this).val(value);
      });
    }

    handleInputCounter() {
      this.elements.eventInputCounter.on("input", function (e) {
        const story = $(this).val();
        const limit = $(this).data("limit");

        if (story.length < limit) {
          $(this)
            .siblings("span")
            .find(".event-create-counter-limit")
            .html(story.length);
        } else {
          $(this).val($(this).val().substring(0, limit));
          if (story.length === limit) {
            $(this)
              .siblings("span")
              .find(".event-create-counter-limit")
              .html(story.length);
          }
          return;
        }
      });
    }

    handleCover() {
      this.elements.eventTopic.on("change", "#event-create-cover", (event) => {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();

          reader.onload = (e) => {
            $(".event-create-cover-uploaded-file").attr("src", e.target.result);

            this.coverImage.data = e.target.result;
            this.coverImage.fileName = file.name;

            $(".event-create-cover-input").removeClass("active");
            $(".event-create-cover-uploaded").addClass("active");
          };
          reader.readAsDataURL(file);
        }
      });

      this.elements.eventTopic.on(
        "click",
        ".event-create-cover-uploaded a",
        (e) => {
          e.preventDefault();

          // Clear the file input and remove the uploaded image
          this.coverImage = {};
          $(".event-create-cover-uploaded-file").attr("src", "");
          $("#event-create-cover").val("");
          $(".event-create-cover-input").addClass("active");
          $(".event-create-cover-uploaded").removeClass("active");
        }
      );
    }

    handleLogo() {
      this.elements.eventCompanionsForm.on(
        "change",
        "#event-create-logo",
        (event) => {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
              $(".event-create-logo-uploaded-file").attr(
                "src",
                e.target.result
              );

              this.companionLogoImage.data = e.target.result;
              this.companionLogoImage.fileName = file.name;

              $(".event-create-logo-input").removeClass("active");
              $(".event-create-logo-uploaded").addClass("active");
            };
            reader.readAsDataURL(file);
          }
        }
      );

      this.elements.eventCompanionsForm.on(
        "click",
        ".event-create-logo-uploaded a",
        (e) => {
          e.preventDefault();

          // Clear the file input and remove the uploaded image
          this.companionLogoImage = {};

          $(".event-create-logo-uploaded-file").attr("src", "");
          $("#event-create-logo").val("");
          $(".event-create-logo-input").addClass("active");
          $(".event-create-logo-uploaded").removeClass("active");
        }
      );
    }

    handleTags() {
      const _this = this;
      this.elements.eventTags.on(
        "change",
        ".event-create-tags-dropdown",
        function () {
          const tagItems = $(".event-create-tags-list span");
          if (tagItems.length < 5) {
            const tagValue = $(this).val();
            _this.tags = [..._this.tags, tagValue];
            const selectedOption = $(this).find("option:selected");
            selectedOption.remove();
            $(".event-create-tags-list").append(`<span>
                <p>${decodeURIComponent(tagValue)}</p>
                <svg class='event-create-tag-delete' width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path id="Vector" d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                <path id="Vector_2" d="M9.16992 14.8299L14.8299 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                <path id="Vector_3" d="M14.8299 14.8299L9.16992 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                </span>`);
          }
        }
      );

      this.elements.eventTags.on(
        "click",
        ".event-create-tag-delete",
        function () {
          const tagValue = $(this).siblings("p").text();
          _this.tags = _this.tags.filter((item) => item !== tagValue);

          $(".event-create-tags-dropdown").append(`
             <option value="${tagValue}">
                ${tagValue}
             </option>          
            `);
          $(this).parent().remove();
        }
      );
    }

    handleCreateGoals() {
      this.elements.eventCreateGoals.find("a").on("click", function (e) {
        e.preventDefault();
        const $counter = $(".event-create-goals-wrap input:last").attr(
          "data-counter"
        );
        const $goalInput = $("#event-create-goals").clone();
        $goalInput.attr("data-counter", parseInt($counter) + 1);
        $(".event-create-goals-wrap").append($goalInput);
      });
    }

    handleInputPrice() {
      $("#event-create-price-input").on("input", function (e) {
        var value = $(this).val();
        value = value.replace(/\D/g, ""); // Remove any non-digit characters
        if (value) {
          value = parseInt(value, 10).toLocaleString(); // Convert to integer and format with thousands separator
        }
        $(this).val(value);
      });
    }

    handleeventPrerequisite() {
      this.elements.eventPrerequisites.on("input", function () {
        const eventPreName = $(this).val();
        const inputeventPre = this;

        if (eventPreName.length > 3) {
          const existeventPre = $(".event-create-pre-list span p");
          const existeventArr = [];

          existeventPre.each(function (index, item) {
            existeventArr.push($(item).data("id"));
          });

          const formData = new FormData();
          formData.append("action", "get_events_prerequisites");
          formData.append("eventName", eventPreName);
          formData.append("existevent", existeventArr);

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            beforeSend() {
              $(".event-create-pre-dropdown").html("");
              $(".event-create-pre-wrap-input").append(
                "<span class='loader'></span>"
              );
            },
            success: function (response) {
              $(".event-create-pre-wrap-input .loader").remove();
              if (response.success) {
                $(".event-create-pre-dropdown").addClass("active");
                const events = response.data.events;

                events.map(function (item) {
                  $(".event-create-pre-dropdown").append(
                    `<a class='event-create-pre-item' href='#' data-id='${
                      item.ID
                    }'>${decodeURIComponent(item.post_name)}</a>`
                  );
                });
              }

              // Event delegation for dynamically added elements
              $(".event-create-pre-dropdown")
                .off("click")
                .on("click", ".event-create-pre-item", function (e) {
                  e.preventDefault();
                  const eventName = $(this).text();
                  const eventID = $(this).data("id");

                  $(".event-create-pre-dropdown").removeClass("active");
                  $(".event-create-pre-list").addClass("active");
                  $(".event-create-pre-list").append(`<span>
            <p data-id='${eventID}'>${eventName}</p>
            <svg class='event-create-pre-delete' width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path id="Vector" d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                <path id="Vector_2" d="M9.16992 14.8299L14.8299 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                <path id="Vector_3" d="M14.8299 14.8299L9.16992 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>`);
                });

              // Event delegation for dynamically added delete buttons
              $(".event-create-pre-list")
                .off("click")
                .on("click", ".event-create-pre-delete", function (e) {
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
      this.elements.eventChapters.on(
        "click",
        ".event-create-add-lesson a",
        function (e) {
          e.preventDefault();

          const lessonWrap = $(this)
            .parent()
            .siblings(".event-create-chapter-lesson:last")
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
        }
      );

      this.elements.eventChapters.on(
        "click",
        ".event-create-add-chapter a",
        function (e) {
          e.preventDefault();

          const chapterCounter = chapterWrap.attr("data-chapter");

          chapterWrap
            .find(".event-create-chapter-counter p")
            .text(`فصل ${parseInt(chapterCounter) + 1}`);

          chapterWrap.attr("data-chapter", parseInt(chapterCounter) + 1);

          $(".event-create-add-chapter").before(chapterWrap.clone());
        }
      );
    }

    handleQuestions() {
      this.elements.eventQuestions.on(
        "click",
        ".event-create-questions-add a",
        function (e) {
          e.preventDefault();

          $(".event-create-questions-add").before(questionBox.clone());
        }
      );

      this.elements.eventQuestions.on("input", "input,textarea", function (e) {
        if ($(this).val().trim() !== "") {
          $(this).addClass("not-empty");
        } else {
          $(this).removeClass("not-empty");
        }
      });
    }

    handleSubmit() {
      this.elements.eventSubmit.on(
        "click",
        ".event-create-submit-check input",
        function (e) {
          $(".event-create-submit-btn button").prop("disabled", !this.checked);
        }
      );

      $(".event-create-form").on("submit", function (e) {
        e.preventDefault();
        console.log(239);
      });
    }
  }

  // class for getting all input tags by name attribute of form and validation each
  class FormValidator {
    constructor(formSelector) {
      this.form = $(formSelector);
      this.inputs = this.form.find("input[name]");
      this.init();
    }

    init() {
      this.form.on("submit", (e) => this.validateForm(e));
    }

    validateForm(event) {
      let isValid = true;
      this.inputs.each((index, input) => {
        if (!this.validateInput($(input))) {
          isValid = false;
        }
      });
      if (!isValid) {
        event.preventDefault();
        alert("Please correct the errors in the form.");
      }
    }
  }

  $(document).ready(() => {
    new FormValidator("#myForm");
  });

  const EdumallCreateEventInit = new EdumallCreateEvent();
})(jQuery);
