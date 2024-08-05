import gsap from "gsap";
import "../persianDatepicker.min";

const dropDownMenu = function (e) {
  console.log(e);
};

(function ($) {
  "use strict";

  const EdumallStudents = function () {
    this.init = function (param) {
      const elements = {
        startDate: $(
          "#course-students .filter-wrap-setting-content-start-date"
        ),
        endDate: $("#course-students .filter-wrap-setting-content-end-date"),
        students: $("#course-students .instructor-students"),
        studentsSort: $("#course-students .instructor-students-sort"),
        courseList: $("#course-students .instructor-students-list"),
        sortBtn: $("#course-students .instructor-students-sort-btn"),
        studentsFilter: $("#course-students .instructor-students-filter"),
        filterBtn: $("#course-students .instructor-students-filter-btn"),
      };
      const plugin = this;

      elements.startDate.persianDatepicker();
      elements.endDate.persianDatepicker();

      plugin.update(elements);
      plugin.sortStudents(elements);
    };

    this.update = function ($el) {
      const plugin = this;

      // $el.sortBtn.on("click", function (e) {
      //   e.preventDefault();
      //   $("#course-students .instructor-students-sort").show();
      //   gsap.to($("#course-students .instructor-students-sort-wrap"), {
      //     y: 0,
      //     duration: 0.3,
      //   });
      // });

      // $el.studentsSort.on(
      //   "click",
      //   ".sort-header-close, .instructor-students-sort-bg",
      //   function (e) {
      //     e.preventDefault();
      //     const tl = gsap.timeline();
      //     tl.to($("#course-students .instructor-students-sort-wrap"), {
      //       y: "100%",
      //       duration: 0.3,
      //     });
      //     tl.to($("#course-students .instructor-students-sort"), {
      //       display: "none",
      //     });
      //   },
      // );

      // $el.studentsSort.one(
      //   "click",
      //   ".instructor-students-sort-wrap-radio span",
      //   function (e) {
      //     const authorID = $(this).find("input").data("author-id");
      //     const sort = $(this).find("input").data("sort");
      //     const tl = gsap.timeline();

      //     $.ajax({
      //       url: ajax_object.ajax_url,
      //       type: "POST",
      //       data: {
      //         action: "students_sort",
      //         authorID: authorID,
      //         sort: sort,
      //       },
      //       success: (response) => {
      //         // Handle successful upload
      //         $("#course-students .all-student-wrap").html(`${response.result}`);
      //         tl.to($("#course-students .instructor-students-sort-wrap"), {
      //           y: "100%",
      //           duration: 0.3,
      //         });
      //         tl.to($("#course-students .instructor-students-sort"), {
      //           display: "none",
      //         });
      //         plugin.init();
      //       },
      //       error: (e) => {
      //         // Handle error
      //         console.log(e);
      //       },
      //     });
      //   },
      // );

      $el.filterBtn.on("click", function (e) {
        e.preventDefault();
        const tl = gsap.timeline();
        tl.to($("#course-students .instructor-students-filter"), {
          display: "block",
        });
        tl.to($("#course-students .instructor-students-filter"), {
          y: 0,
          duration: 0.3,
        });
      });

      $el.studentsFilter.on("click", ".sort-header-close", function (e) {
        e.preventDefault();
        const tl = gsap.timeline();
        tl.to($("#course-students .instructor-students-filter"), {
          y: "100%",
          duration: 0.3,
        });
        tl.to($("#course-students .instructor-students-filter"), {
          display: "none",
        });
        $("#course-students .other-city").hide();
        $("#course-students .filter-wrap-setting-content-show-all")
          .parent()
          .show();
      });

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

      $el.studentsFilter
        .find(".instructor-students-filter-buttons-show")
        .on("click", function (e) {
          e.preventDefault();

          const instructor = $(this).data("id");
          const startDate = $(
            "#course-students .filter-wrap-setting-content-start-date"
          ).attr("data-gdate");
          const endDate = $(
            "#course-students .filter-wrap-setting-content-end-date"
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
              $("#course-students .all-student-wrap").html(
                `${response.result}`
              );
              const tl = gsap.timeline();
              tl.to($("#course-students .instructor-students-filter"), {
                y: "100%",
                duration: 0.3,
              });
              tl.to($("#course-students .instructor-students-filter"), {
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

      $el.studentsFilter.on(
        "click",
        ".filter-wrap-setting-content-show-all",
        function (e) {
          e.preventDefault();
          $(this).hide();
          $("#course-students .other-city").css("display", "flex");
        }
      );

      $el.courseList.on("change", "select", function (e) {
        const courseIds = $(this).val();
        const authorID = $(this).find(":selected").data("author-id");
        const type = $(this).find(":selected").data("type");

        $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "select_course",
            courseIds: courseIds,
            authorID: authorID,
            type: type,
          },
          success: (response) => {
            // Handle successful upload
            $("#course-students .all-student-wrap").html(`${response.result}`);
          },
          error: (e) => {
            // Handle error
            console.log(e);
          },
        });
      });
    };

    this.sortStudents = function ($el) {
      $el.students
        .find(".instructor-students-sort-btn")
        .on("click", function (e) {
          e.preventDefault();
          const selectCourse = $(
            ".instructor-students-list-wrap select :selected"
          ).data("current");

          if (selectCourse === "all") {
            $("#course-students #sort_by_progress").hide();
          } else {
            $("#course-students #sort_by_progress").show();
          }

          $("#course-students .instructor-students-sort").show();
          gsap.to($("#course-students .instructor-students-sort-wrap"), {
            y: 0,
            duration: 0.3,
          });
        });

      $el.studentsSort
        .find(".sort-header-close,.instructor-students-sort-bg")
        .on("click", function (e) {
          e.preventDefault();
          const tl = gsap.timeline();
          tl.to($("#course-students .instructor-students-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($("#course-students .instructor-students-sort"), {
            display: "none",
          });
        });

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
          const container = $("#course-students .all-student-wrap");
          container.empty(); // Clear existing content in the container

          // Append sorted elements back to the container
          sortedElements.each(function () {
            container.append(this);
          });

          const tl = gsap.timeline();
          tl.to($("#course-students .instructor-students-sort-wrap"), {
            y: "100%",
            duration: 0.3,
          });
          tl.to($("#course-students .instructor-students-sort"), {
            display: "none",
          });
        });
    };
  };

  const EdumallStudentsInit = new EdumallStudents();
  EdumallStudentsInit.init();
})(jQuery);
