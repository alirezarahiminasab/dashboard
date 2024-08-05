import gsap from "gsap";
import "../persianDatepicker.min";

const dropDownMenu = function (e) {
  console.log(e);
};

(function ($) {
  "use strict";

  const EventStudents = function () {
    this.init = function (param) {
      const elements = {
        startDate: $(
          "#event-students  .filter-wrap-setting-content-start-date"
        ),
        endDate: $("#event-students  .filter-wrap-setting-content-end-date"),
        students: $("#event-students  .instructor-students"),
        studentsSort: $("#event-students  .instructor-students-sort"),
        courseList: $("#event-students  .instructor-students-list"),
        sortBtn: $("#event-students  .instructor-students-sort-btn"),
        studentsFilter: $("#event-students  .instructor-students-filter"),
        filterBtn: $("#event-students  .instructor-students-filter-btn"),
      };
      const plugin = this;

      elements.startDate.persianDatepicker();
      elements.endDate.persianDatepicker();

      plugin.update(elements);
      plugin.sortStudents(elements);
    };

    this.update = function ($el) {
      const plugin = this;

      ////////////////////////////////////////////////////////// TODO
      $el.courseList.on("change", "select", function (e) {
        const eventID = $(this).val();
        $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "get_shops",
            eventID: eventID,
          },
          success: (response) => {
            if (response.data.length < 5) {
              $("#event-students .instructor-students-wrap-table").addClass(
                "hide"
              );
              $(
                "#event-students .instructor-students-wrap-empty-student"
              ).removeClass("hide");
              $("#event-students .instructor-students-wrap-setting").addClass(
                "hide"
              );
            }
            // Handle successful upload
            else {
              const matches = response.data.match(/div class="student-box"/g);
              $("#event-students .all-student-wrap").html(`${response.data}`);
              $("#event-students .instructor-students-wrap-table").removeClass(
                "hide"
              );
              $(
                "#event-students .instructor-students-wrap-empty-student"
              ).addClass("hide");
              $(
                "#event-students .instructor-students-wrap-setting"
              ).removeClass("hide");
              $(
                "#event-students .instructor-students-wrap-table-count span"
              ).html(`(${matches ? matches.length : 0})`);
            }
          },
          error: (e) => {
            // Handle error
            console.log(e);
          },
        });
      });

      //////////////////////////////////////////////////////////
      $el.filterBtn.on("click", function (e) {
        e.preventDefault();
        const tl = gsap.timeline();
        tl.to($("#event-students .instructor-students-filter"), {
          display: "block",
        });
        tl.to($("#event-students .instructor-students-filter"), {
          y: 0,
          duration: 0.3,
        });
      });
      //////////////////////////////////////////////////////////
      $el.studentsFilter.on("click", ".sort-header-close", function (e) {
        e.preventDefault();
        const tl = gsap.timeline();
        tl.to($("#event-students .instructor-students-filter"), {
          y: "100%",
          duration: 0.3,
        });
        tl.to($("#event-students .instructor-students-filter"), {
          display: "none",
        });
        $("#event-students .other-city").hide();
        $("#event-students .filter-wrap-setting-content-show-all")
          .parent()
          .show();
      });
      //////////////////////////////////////////////////////////
      $el.studentsFilter.on(
        "click",
        ".filter-wrap-setting-content-all",
        function (e) {
          const inputBoxes = $(this).parent().parent().find("input");

          if ($(this).prop("checked") === true) {
            inputBoxes.prop("checked", true);
          } else {
            inputBoxes.prop("checked", false);
          }
        }
      );
      //////////////////////////////////////////////////////////
      $el.studentsFilter.on(
        "click",
        ".filter-wrap-setting-content input:not(filter-wrap-setting-content-all)",
        function (e) {
          const inputBoxes = $(this)
            .parent()
            .parent()
            .find(".filter-wrap-setting-content-all");

          if ($(this).prop("checked") === false) {
            inputBoxes.prop("checked", false);
          }
        }
      );
      //////////////////////////////////////////////////////////
      $el.studentsFilter
        .find(".instructor-students-filter-buttons-show")
        .on("click", function (e) {
          e.preventDefault();

          const instructor = $(this).data("id");
          const startDate = $(
            "#event-students.filter-wrap-setting-content-start-date"
          ).attr("data-gdate");
          const endDate = $(
            "#event-students.filter-wrap-setting-content-end-date"
          ).attr("data-gdate");
          const cities = $el.studentsFilter.find(
            ".filter-wrap-setting-content-city input:checked"
          );

          const citiesArr = [];

          cities.each((index, el) => {
            citiesArr.push($(el).val());
          });

          $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
              action: "students_filter",
              cities: citiesArr,
              instructor: instructor,
              startDate: startDate?.replace(/\//g, "-"),
              endDate: endDate?.replace(/\//g, "-"),
            },
            success: (response) => {
              // Handle successful upload
              $("#event-students .all-student-wrap").html(`${response.result}`);
              const tl = gsap.timeline();
              tl.to($("#event-students .instructor-students-filter"), {
                y: "100%",
                duration: 0.3,
              });
              tl.to($("#event-students .instructor-students-filter"), {
                display: "none",
              });
              plugin.init();
            },
            error: (e) => {
              // Handle error
              console.log(e);
            },
          });
        });
      //////////////////////////////////////////////////////////
      $el.studentsFilter.on(
        "input",
        ".filter-wrap-setting-content-search input",
        function (e) {
          const inputValue = e.target.value;
          const container = $(this).parent().parent();

          if (e.target.value.length > 2) {
            $(this).parent().siblings(".main-city").hide();
            $(this)
              .parent()
              .siblings(".filter-wrap-setting-content-show-all")
              .hide();
            $(`span[data-city*=${inputValue}]`).each(function (index, el) {
              $(el).css("display", "flex");
              container.append(el);
            });
          } else {
            $(this).parent().siblings(".main-city").show();
            $(this)
              .parent()
              .siblings(".filter-wrap-setting-content-show-all")
              .show();
            $(`span[data-city*=${inputValue}]`).each(function (index, el) {
              $(el).css("display", "none");
              container.append(el);
            });
          }
        }
      );
      //////////////////////////////////////////////////////////
      $el.studentsFilter.on(
        "click",
        ".filter-wrap-setting-content-show-all",
        function (e) {
          e.preventDefault();
          $(this).hide();
          $("#event-students .other-city").css("display", "flex");
        }
      );
    };

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    this.sortStudents = function ($el) {
      $el.students
        .find(".instructor-students-sort-btn")
        .on("click", function (e) {
          e.preventDefault();
          const selectCourse = $(
            ".instructor-students-list-wrap select :selected"
          ).data("current");

          if (selectCourse === "all") {
            $("#event-students #sort_by_progress").hide();
          } else {
            $("#event-students #sort_by_progress").show();
          }

          $("#event-students .instructor-students-sort").show();
          gsap.to($("#event-students .instructor-students-sort-wrap"), {
            y: 0,
            duration: 0.3,
          });
        });
      //////////////////////////////////////////////////////////
      $el.studentsSort
        .find(".sort-header-close,.instructor-students-sort-bg")
        .on("click", function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          tl.to($("#event-students .instructor-students-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($("#event-students .instructor-students-sort"), {
            display: "none",
          });
        });
      //////////////////////////////////////////////////////////
      $el.studentsSort
        .find(".instructor-students-sort-wrap-radio span")
        .on("click", function (e) {
          const sortType = $(this).data("sort"); // Get the sort type from data-sort attribute of clicked radio button

          // Select and sort the div elements based on data attribute specified by sortType
          const sortedElements = $el.students
            .find(".student-box")
            .sort(function (a, b) {
              // Convert data values to integers if they are numeric and compare for descending order
              return (
                parseInt($(b).data(sortType)) - parseInt($(a).data(sortType))
              );
            });

          // Select the container that wraps the items to be sorted
          const container = $("#event-students .all-student-wrap");
          container.empty(); // Clear existing content in the container

          // Append sorted elements back to the container
          sortedElements.each(function () {
            container.append(this);
          });

          const tl = gsap.timeline();
          tl.to($("#event-students .instructor-students-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($("#event-students .instructor-students-sort"), {
            display: "none",
          });
        });
    };
  };

  const EventStudentsInit = new EventStudents();
  EventStudentsInit.init();
})(jQuery);
