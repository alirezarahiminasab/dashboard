import toast from "../toast";
import gsap from "gsap";
import moment from "moment-jalaali";
console.log("_js file");

(function ($) {
  "use strict";

  let chapterWrap = $(".course-create-chapter:last").clone();
  const questionBox = $(".course-create-questions-input").clone();

  class CardManager {
    constructor() {
      this.editingCardId = null; // To track the card being edited
      this.editingCompanionId = null;
      this.editingTicketId = null;

      this.cards = [];
      this.companions = [];
      this.tickets = [];
      this.counter = 0;
      this.companionCounter = 0;
      this.ticketCounter = 0;

      this.editModeInit();
    }

    ////////////////////////EDIT_MODE/////////////////////////
    //////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////

    editModeInit() {
      this.isEdit = $("#create_online_event_edit_mode").text() === "true";
      this.eventData = JSON.parse($("#create_online_event_data").text());
      this.ticketsData = JSON.parse($("#create_online_event_tickets").text());

      console.log(this.eventData);
      // Remove the <p> tags after reading the data
      $(
        "#create_online_event_edit_mode, #create_online_event_data, #create_online_event_tickets"
      ).remove();

      if (this.isEdit) {
        this.prefillSessions();
        this.prefillCompanions();
        this.prefillTickets();
      }
    }

    prefillSessions() {
      const _this = this;
      this.eventData["sessions"].forEach(function (session) {
        const cardId = _this.addCard({
          sessionTitleValue: session["title"],
          sessionPlatformValue: session["platform"],
          sessionDateValue: moment
            .unix(session["startDateTime"])
            .format("jYYYY/jMM/jDD"),
          sessionStartTimeValue: moment
            .unix(session["startDateTime"])
            .format("HH:mm"),
          sessionFinishTimeValue: moment
            .unix(session["finishDateTime"])
            .format("HH:mm"),
          sessionDescription: session["description"],
          sessionClassUrl: session["classUrl"],
        });
      });
    }

    prefillCompanions() {
      const defaultImg = $("#base-companion-card-template img").attr("src");

      const _this = this;
      this.eventData["companions"].forEach(function (companion) {
        const companionId = _this.addCompanion({
          companionName: companion["name"],
          companionLogo:
            companion["logoURL"] !== "" ? companion["logoURL"] : defaultImg,
          companionLogoName: companion["logoURL"] !== "" ? "from_database" : "",
        });
      });
    }

    prefillTickets() {
      const _this = this;
      this.ticketsData.forEach(function (ticket) {
        const ticketId = _this.addTicket({
          ticketTitle: ticket["title"],
          ticketNumber: ticket["count"],
          ticketPrice: ticket["price"],
          saleStartDate: moment
            .unix(ticket["startDateTime"])
            .format("jYYYY/jMM/jDD"),
          saleFinishDate: moment
            .unix(ticket["finishDateTime"])
            .format("jYYYY/jMM/jDD"),
        });
      });
    }

    //////////////////////////////////////////////////////////
    dateTime2unix(dateTime) {
      return dateTime
        ? moment(`${dateTime}`, "jYYYY-jMM-jDD HH:mm").unix()
        : null;
    }

    //////////////////////////Session/////////////////////////
    //////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////

    addCard(card) {
      this.counter++;
      card.id = this.counter;
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
      return this.cards.map((card) => ({
        ...card,
        sessionStartUnix: this.dateTime2unix(
          `${card.sessionDateValue} ${card.sessionStartTimeValue}`
        ),
        sessionFinishUnix: this.dateTime2unix(
          `${card.sessionDateValue} ${card.sessionFinishTimeValue}`
        ),
      }));
    }
    /////////////////////////////Companion/////////////////////////////
    addCompanion(companion) {
      this.companionCounter++;
      companion.id = this.companionCounter;
      this.companions.push(companion);
      return companion.id;
    }

    updateCompanion(id, updatedCompanion) {
      const index = this.companions.findIndex(
        (companion) => companion.id === id
      );
      if (index !== -1) {
        this.companions[index] = {
          ...this.companions[index],
          ...updatedCompanion,
        };
      }
    }

    deleteCompanion(id) {
      this.companions = this.companions.filter(
        (companion) => companion.id !== id
      );
    }

    getCompanion(id) {
      return this.companions.find((companion) => companion.id === id);
    }

    getAllCompanions() {
      return this.companions;
    }

    /////////////////////////////Ticket/////////////////////////////
    addTicket(ticket) {
      this.ticketCounter++;
      ticket.id = this.ticketCounter;
      this.tickets.push(ticket);
      return ticket.id;
    }

    updateTicket(id, updatedTicket) {
      const index = this.tickets.findIndex((ticket) => ticket.id === id);
      if (index !== -1) {
        this.tickets[index] = { ...this.tickets[index], ...updatedTicket };
      }
    }

    deleteTicket(id) {
      this.tickets = this.tickets.filter((ticket) => ticket.id !== id);
    }

    getTicket(id) {
      return this.tickets.find((ticket) => ticket.id === id);
    }

    getAllTickets() {
      return this.tickets.map((card) => ({
        ...card,
        saleStartDate: this.dateTime2unix(card.saleStartDate),
        saleFinishDate: this.dateTime2unix(card.saleFinishDate),
      }));
    }
  }

  // SECTION

  class CreateEvent extends CardManager {
    constructor() {
      super();

      this.tags = [];
      this.elements = {
        eventInputCounter: $(".event-create-input"),
        eventTopic: $("#event-create-topic"),
        eventTags: $(".event-create-tags"),
        eventSubmit: $(".event-create-submit"),
        eventSessions: $(".event-create-sessions"),
        eventSessionsForm: $(".event-create-sessions-form"),
        eventSessionsFull: $(".event-create-sessions-full"),
        eventCompanions: $(".event-create-companions"),
        eventCompanionsForm: $(".event-create-companions-form"),
        eventCompanionsFull: $(".event-create-companions-full"),
        eventTicketsForm: $(".event-create-tickets"),
        eventTicketsFull: $(".event-create-tickets-full"),
        eventCompanionLogoInput: $(".event-create-logo-input"),
        eventCompanionLogoUploaded: $(".event-create-logo-uploaded"),
      };

      this.timer = null;
      this.handleInputCounter();
      this.handleCover();
      this.handleTags();
      this.handleInputPrice();
      this.handleSubmit();
      this.handleSessions();
      this.handleCompanions();
      this.handleTickets();
      this.handleDatePicker();
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

    categories = {
      ticket: ["eventTicketsForm", "eventTicketsFull"],
      session: ["eventSessions", "eventSessionsForm", "eventSessionsFull"],
      companion: [
        "eventCompanions",
        "eventCompanionsForm",
        "eventCompanionsFull",
      ],
      logo: ["eventCompanionLogoInput", "eventCompanionLogoUploaded"],
    };

    setActiveSection(sectionName) {
      let category = null;

      // Determine the category of the sectionName
      for (const [key, sections] of Object.entries(this.categories)) {
        if (sections.includes(sectionName)) {
          category = key;
          break;
        }
      }

      if (category) {
        // Deactivate all sections within the same category
        this.categories[category].forEach((section) => {
          this.elements[section].removeClass("active");
        });

        // Activate the specified section
        this.elements[sectionName].addClass("active");
      }

      if (sectionName === "eventCompanionLogoInput") {
        // Clear the file input and remove the uploaded image
        const defaultImg = $("#base-companion-card-template img").attr("src");
        $(".event-create-logo-uploaded-file").attr("src", defaultImg);
        $(".event-create-logo-uploaded-file").attr("fileName", "empty");
        $("#event-create-logo").val("");
      }
    }

    // SECTION
    addOrUpdateSessionCard() {
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
      const sessionDescription = sessionForm
        .find(`[name="event-create-session-description"]`)
        .val();
      const sessionClassUrl = sessionForm
        .find(`[name="event-create-platform-link"]`)
        .val();
      if (
        !sessionTitleValue ||
        !sessionPlatformValue ||
        !sessionDateValue ||
        !sessionStartTimeValue ||
        !sessionFinishTimeValue
      ) {
        alert("Please fill in all required fields.");
        return;
      }

      const cardData = {
        sessionTitleValue,
        sessionPlatformValue,
        sessionDateValue,
        sessionStartTimeValue,
        sessionFinishTimeValue,
        sessionDescription,
        sessionClassUrl,
      };

      if (this.editingCardId) {
        // Update existing card
        this.updateCard(this.editingCardId, cardData);
        const cardElement = $(`.card-type1[data-id="${this.editingCardId}"]`);
        cardElement
          .find('[ref="event-create-session-title"]')
          .text(sessionTitleValue);
        cardElement
          .find('[ref="event-create-session-platform"]')
          .text(sessionPlatformValue);
        cardElement
          .find('[ref="event-create-session-start-date"]')
          .text(`${sessionDateValue} - ${sessionStartTimeValue}`);
        cardElement
          .find('[ref="event-create-session-finish-date"]')
          .text(`${sessionDateValue} - ${sessionFinishTimeValue}`);
        cardElement
          .find('[ref="event-create-session-description"]')
          .text(sessionDescription);
        cardElement
          .find('[ref="event-create-platform-link"]')
          .text(sessionClassUrl);
      } else {
        // Create new card
        const cardId = this.addCard(cardData);

        const newCard = $("#base-card-template").clone();
        newCard.attr("data-id", cardId);
        newCard
          .find('[ref="event-create-session-title"]')
          .text(sessionTitleValue);
        newCard
          .find('[ref="event-create-session-platform"]')
          .text(sessionPlatformValue);
        newCard
          .find('[ref="event-create-session-start-date"]')
          .text(`${sessionDateValue} - ${sessionStartTimeValue}`);
        newCard
          .find('[ref="event-create-session-finish-date"]')
          .text(`${sessionDateValue} - ${sessionFinishTimeValue}`);
        newCard
          .find('[ref="event-create-session-description"]')
          .text(sessionDescription);
        newCard
          .find('[ref="event-create-platform-link"]')
          .text(sessionClassUrl);
        newCard.removeAttr("id"); // remove the id attribute from the cloned element
        newCard.show(); // show the cloned card

        this.elements.eventSessionsFull.append(newCard);
      }

      // Reset form and editing state
      this.editingCardId = null;
      sessionForm.find("input, select").val("");
      this.setActiveSection("eventSessionsFull");
    }
    // TODO

    handleSessions() {
      const createSession = this.elements.eventSessions;
      const sessionForm = this.elements.eventSessionsForm;
      const sessionFull = this.elements.eventSessionsFull;

      createSession.on("click", ".event-create-extract-content", () => {
        this.editingCardId = null; // Reset editing state

        this.setActiveSection("eventSessionsForm");
      });

      sessionFull.on("click", ".event-create-add-content", () => {
        this.editingCardId = null; // Reset editing state
        this.setActiveSection("eventSessionsForm");
        sessionForm.find("input, select, textarea").val(""); // Clear form fields
      });

      sessionForm.on("click", ".btn-submit", (e) => {
        this.addOrUpdateSessionCard();
      });

      sessionForm.on("click", ".btn-cancel", () => {
        if (sessionFull.find(".card-type1").length > 0) {
          this.setActiveSection("eventSessionsFull");
        } else {
          this.setActiveSection("eventSessions");
        }
      });

      sessionFull.on("click", ".edit-card", (e) => {
        const cardId = $(e.currentTarget).closest(".card-type1").data("id");
        const cardData = this.getCard(cardId);

        this.editingCardId = cardId;

        sessionForm
          .find(`[name="event-create-session-title"]`)
          .val(cardData.sessionTitleValue);
        sessionForm
          .find(`[name="event-create-platform"]`)
          .val(cardData.sessionPlatformValue);
        sessionForm
          .find(`[name="event-create-session-date"]`)
          .val(cardData.sessionDateValue);
        sessionForm
          .find(`[name="event-create-session-start-time"]`)
          .val(cardData.sessionStartTimeValue);
        sessionForm
          .find(`[name="event-create-session-finish-time"]`)
          .val(cardData.sessionFinishTimeValue);
        sessionForm
          .find(`[name="event-create-session-description"]`)
          .val(cardData.sessionDescription);
        sessionForm
          .find(`[name="event-create-platform-link"]`)
          .val(cardData.sessionClassUrl);

        this.setActiveSection("eventSessionsForm");
      });

      sessionFull.on("click", ".delete-card", (e) => {
        const cardId = $(e.currentTarget).closest(".card-type1").data("id");
        this.deleteCard(cardId);
        $(e.currentTarget).closest(".card-type1").remove();

        // Check if all cards are deleted
        if (sessionFull.find(".card-type1").length <= 1) {
          this.setActiveSection("eventSessions");
        }
      });
    }
    // SECTION
    addOrUpdateCompanionCard() {
      const companionForm = this.elements.eventCompanionsForm;

      const companionName = companionForm
        .find(`[name="event-create-companion-name"]`)
        .val();
      const companionLogo = $(".event-create-logo-uploaded-file").attr("src");
      const companionLogoName = $(".event-create-logo-uploaded-file").attr(
        "fileName"
      );

      if (!companionName) {
        alert("Please fill in companionName fields.");
        return;
      }

      const companionData = {
        companionName,
        companionLogo,
        companionLogoName, //check this later in ajax
      };

      if (this.editingCompanionId) {
        this.updateCompanion(this.editingCompanionId, companionData);

        const cardElement = $(
          `.card-type2[data-id="${this.editingCompanionId}"]`
        );
        cardElement
          .find('p[ref="event-create-companion-name"]')
          .text(companionName);
        cardElement
          .find('img[ref="event-create-companion-logo"]')
          .attr("src", companionLogo);
      } else {
        const companionId = this.addCompanion(companionData);

        const newCard = $("#base-companion-card-template").clone();
        newCard.attr("data-id", companionId);
        newCard
          .find('p[ref="event-create-companion-name"]')
          .text(companionName);
        newCard
          .find('img[ref="event-create-companion-logo"]')
          .attr("src", companionLogo);
        newCard.removeAttr("id"); // remove the id attribute from the cloned element
        newCard.show(); // show the cloned card

        this.elements.eventCompanionsFull.append(newCard);
      }

      // Reset form and editing state
      this.editingCompanionId = null;
      companionForm.find("input").val("");
      this.companionLogoImage = {};
      this.setActiveSection("eventCompanionsFull");
    }
    // TODO

    handleCompanions() {
      const createCompanion = this.elements.eventCompanions;
      const companionForm = this.elements.eventCompanionsForm;
      const companionFull = this.elements.eventCompanionsFull;

      /////////////////////////////createCompanion/////////////////////////////
      createCompanion.on("click", ".event-create-extract-content", () => {
        this.editingCompanionId = null;
        this.setActiveSection("eventCompanionLogoInput");
        this.setActiveSection("eventCompanionsForm");
      });

      /////////////////////////////companionForm/////////////////////////////
      companionForm.on("change", "#event-create-logo", (event) => {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();

          reader.onload = (e) => {
            $(".event-create-logo-uploaded-file").attr("src", e.target.result);
            $(".event-create-logo-uploaded-file").attr("fileName", file.name);
            this.setActiveSection("eventCompanionLogoUploaded");
          };
          reader.readAsDataURL(file);
        }
      });

      companionForm.on("click", ".event-create-logo-uploaded a", (e) => {
        e.preventDefault();

        this.setActiveSection("eventCompanionLogoInput");
      });

      companionForm.on("click", ".btn-submit", (e) => {
        this.addOrUpdateCompanionCard();
      });

      companionForm.on("click", ".btn-cancel", () => {
        if (companionFull.find(".card-type2").length > 1) {
          this.setActiveSection("eventCompanionsFull");
        } else {
          this.setActiveSection("eventCompanions");
        }
      });
      /////////////////////////////companionFull/////////////////////////////
      companionFull.on("click", ".event-create-add-content", () => {
        this.editingCompanionId = null;

        this.setActiveSection("eventCompanionLogoInput");
        this.setActiveSection("eventCompanionsForm");
        companionForm.find("input").val("");
      });

      companionFull.on("click", ".edit-card", (e) => {
        const companionId = $(e.currentTarget)
          .closest(".card-type2")
          .data("id");
        const companionData = this.getCompanion(companionId);

        this.editingCompanionId = companionId;

        companionForm
          .find(`[name="event-create-companion-name"]`)
          .val(companionData.companionName);

        // Preload the logo if exists
        $(".event-create-logo-uploaded-file").attr(
          "src",
          companionData.companionLogo
        );
        $(".event-create-logo-uploaded-file").attr(
          "fileName",
          companionData.companionLogoName
        );

        if (companionData.companionLogoName === "") {
          this.setActiveSection("eventCompanionLogoInput");
        } else {
          this.setActiveSection("eventCompanionLogoUploaded");
        }

        this.setActiveSection("eventCompanionsForm");
      });

      companionFull.on("click", ".delete-card", (e) => {
        const companionId = $(e.currentTarget)
          .closest(".card-type2")
          .data("id");
        this.deleteCompanion(companionId);
        $(e.currentTarget).closest(".card-type2").remove();

        if (companionFull.find(".card-type2").length < 2) {
          this.setActiveSection("eventCompanions");
        }
      });
    }
    // SECTION
    addOrUpdateTicketCard() {
      const ticketForm = this.elements.eventTicketsForm;

      const ticketTitle = ticketForm
        .find(`[name="event-create-ticket-title"]`)
        .val();
      const ticketNumber = ticketForm
        .find(`[name="event-create-ticket-number"]`)
        .val();
      const ticketPrice = ticketForm
        .find(`[name="event-create-ticket-price"]`)
        .val();
      const saleStartDate = ticketForm
        .find(`[name="event-create-sale-start-date"]`)
        .val();
      const saleFinishDate = ticketForm
        .find(`[name="event-create-sale-finish-date"]`)
        .val();

      if (
        !ticketTitle ||
        !ticketNumber ||
        !ticketPrice ||
        !saleStartDate ||
        !saleFinishDate
      ) {
        alert("Please fill in all required fields.");
        return;
      }

      const ticketData = {
        ticketTitle,
        ticketNumber,
        ticketPrice,
        saleStartDate,
        saleFinishDate,
      };

      if (this.editingTicketId) {
        this.updateTicket(this.editingTicketId, ticketData);
        const ticketElement = $(
          `.card-type1[data-id="${this.editingTicketId}"]`
        );
        ticketElement
          .find('[ref="event-create-ticket-title"]')
          .text(ticketTitle);
        ticketElement
          .find('[ref="event-create-ticket-number"]')
          .text(ticketNumber);
        ticketElement
          .find('[ref="event-create-ticket-price"]')
          .text(ticketPrice);
        ticketElement
          .find('[ref="event-create-sale-start-date"]')
          .text(saleStartDate);
        ticketElement
          .find('[ref="event-create-sale-finish-date"]')
          .text(saleFinishDate);
      } else {
        const ticketId = this.addTicket(ticketData);

        const newTicket = $("#base-ticket-card-template").clone();
        newTicket.attr("data-id", ticketId);
        newTicket.find('[ref="event-create-ticket-title"]').text(ticketTitle);
        newTicket.find('[ref="event-create-ticket-number"]').text(ticketNumber);
        newTicket.find('[ref="event-create-ticket-price"]').text(ticketPrice);
        newTicket
          .find('[ref="event-create-sale-start-date"]')
          .text(saleStartDate);
        newTicket
          .find('[ref="event-create-sale-finish-date"]')
          .text(saleFinishDate);
        newTicket.removeAttr("id"); // remove the id attribute from the cloned element
        newTicket.show(); // show the cloned ticket

        this.elements.eventTicketsFull.append(newTicket);
      }

      // Reset form and editing state
      this.editingTicketId = null;
      ticketForm.find("input").val("");
      this.setActiveSection("eventTicketsFull");
    }
    // TODO

    handleTickets() {
      const ticketForm = this.elements.eventTicketsForm;
      const ticketFull = this.elements.eventTicketsFull;

      ticketForm.on("click", ".btn-submit", (e) => {
        this.addOrUpdateTicketCard();
      });

      ticketForm.on("click", ".btn-cancel", () => {
        this.setActiveSection("eventTicketsFull");
      });

      ticketFull.on("click", ".event-create-add-content", () => {
        this.editingTicketId = null;
        ticketForm.find("input").val("");

        if (ticketFull.find(".card-type1").length > 1) {
          ticketForm.find(".btn-cancel").removeClass("disabled");
        } else {
          ticketForm.find(".btn-cancel").addClass("disabled");
        }

        this.setActiveSection("eventTicketsForm");
      });

      ticketFull.on("click", ".edit-card", (e) => {
        const ticketId = $(e.currentTarget).closest(".card-type1").data("id");
        const ticketData = this.getTicket(ticketId);

        this.editingTicketId = ticketId;

        ticketForm
          .find(`[name="event-create-ticket-title"]`)
          .val(ticketData.ticketTitle);
        ticketForm
          .find(`[name="event-create-ticket-number"]`)
          .val(ticketData.ticketNumber);
        ticketForm
          .find(`[name="event-create-ticket-price"]`)
          .val(ticketData.ticketPrice);
        ticketForm
          .find(`[name="event-create-sale-start-date"]`)
          .val(ticketData.saleStartDate);
        ticketForm
          .find(`[name="event-create-sale-finish-date"]`)
          .val(ticketData.saleFinishDate);
        ticketForm.find(".btn-cancel").removeClass("disabled");
        this.setActiveSection("eventTicketsForm");
      });

      ticketFull.on("click", ".delete-card", (e) => {
        const ticketId = $(e.currentTarget).closest(".card-type1").data("id");
        this.deleteTicket(ticketId);
        $(e.currentTarget).closest(".card-type1").remove();

        if (ticketFull.find(".card-type1").length < 2) {
          this.editingTicketId = null;
          ticketForm.find("input").val("");
          ticketForm.find(".btn-cancel").addClass("disabled");
          this.setActiveSection("eventTicketsForm");
        }
      });
    }

    // handleInputTime() {
    //   this.elements.eventInputTime.on("input", function () {
    //     let value = $(this).val().replace(/\D/g, ""); // Remove non-numeric characters
    //     if (value.length > 4) value = value.slice(0, 4); // Limit to 4 digits

    //     if (value.length > 2) {
    //       value = value.slice(0, 2) + ":" + value.slice(2);
    //     }

    //     $(this).val(value);
    //   });
    // }

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
            $(".event-create-cover-uploaded-file").attr("fileName", file.name);
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
          $(".event-create-cover-uploaded-file").attr("src", "empty");
          $(".event-create-cover-uploaded-file").attr("fileName", "empty");
          $("#event-create-cover").val("");
          $(".event-create-cover-input").addClass("active");
          $(".event-create-cover-uploaded").removeClass("active");
        }
      );
    }

    handleTags() {
      const _this = this;
      $(".event-create-tags-list span p").each(function () {
        const tagText = $(this).text();
        _this.tags.push(tagText);
        console.log(_this.tags);
      });

      console.log(_this.tags);
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

    handleSubmit() {
      this.elements.eventSubmit.on(
        "click",
        ".event-create-submit-check input",
        function (e) {
          $(".event-create-submit-btn button").prop("disabled", !this.checked);
        }
      );

      const _this = this;
      $("#event-create-form").on("submit", function () {
        e.preventDefault();
        const formData = new FormData(this);

        const _formData = $(this).serializeArray();
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

        // formData.append("action", "create_event");
        formData.append("event-create-tags", _this.tags.join("-"));
        formData.append("is_edit", _this.isEdit);
        formData.append("eventID", _this.eventData?._id);

        const coverImage = $(".event-create-cover-uploaded-file").attr("src");
        const coverImageFileName = $(".event-create-cover-uploaded-file").attr(
          "fileName"
        );
        formData.append("event-create-cover-data", coverImage);
        formData.append("event-create-cover-fileName", coverImageFileName);

        // Add card data to the form data
        formData.append("sessions", JSON.stringify(_this.getAllCards()));
        formData.append("companions", JSON.stringify(_this.getAllCompanions()));
        formData.append("tickets", JSON.stringify(_this.getAllTickets()));

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
  }

  const CreateEventInit = new CreateEvent();
})(jQuery);
