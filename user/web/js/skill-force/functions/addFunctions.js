export default {
  appInputFile() {
    $(".add-prepod-group").prepend(`
    <div class="new-prepod">
      <label class="create-resume-form_main-second-title">
        Укажите данные преподавателя
        <input 
          placeholder="Фамилия имя" 
          type="text" 
          name="fioprepod[]" 
          class="input-t create-resume-form-input-t"
        >
      </label>
      <h4 class="create-resume-form_main-second-title">
      Добавьте фото преподавателя
      </h4>
      <div class="input__wrapper">
        <label class="input__file-button">
          <input 
            name="photoprepod[]" 
            type="file"
            class="input input__file"
          >
          <span class="input__file-button-text">Загрузить</span>
        </label>
      </div>
    </div>
  `);
  },
  addProgramm() {
    if (
      $('.create-module-task.teory input[name="lesson-name"]').val().length !=
        0 &&
      $('.create-module-task.teory input[name="lesson-describe"]').val()
        .length != 0 &&
      $(
        '.create-module-task.teory input[name="document-to-lesson-name[]"]'
      ).val().length != 0 &&
      $('.create-module-task.teory input[name="document-to-lesson[]"]').val()
        .length != 0
    ) {
      $(".lesson-input-req").removeClass("redq");
      $(".input__file-button-text").removeClass("red");

      var lessonName = $('.create-module-task.teory input[name="lesson-name"]'),
        lessonDescribe = $(
          '.create-module-task.teory input[name="lesson-describe"]'
        ),
        lessonDocName = $(
          '.create-module-task.teory input[name="document-to-lesson-name[]"]'
        ),
        lessonDocLink = $(
          '.create-module-task.teory input[name="document-to-lesson[]"]'
        ),
        arr = [],
        lessonDocNameArr = [],
        lessonDocLinkArr = [];

      lessonDocName.each(function () {
        lessonDocNameArr.push($(this).val());
      });
      lessonDocLink.each(function () {
        lessonDocLinkArr.push($(this).val());
      });
      arr.lessonName = lessonName.val();
      arr.lessonDescribe = lessonDescribe.val();
      arr.lessonDocName = lessonDocNameArr;
      arr.lessonDocLink = lessonDocLinkArr;
      lesson.teory = arr;

      $(".addprogram_anket-course_lessons").append(
        '<div class="addprogram_anket-course_lessons-item"><p class="addprogram_anket-course_lessons-item-name">Лекция №1</p><div class="addprogram_anket-course_lessons-item-main"><p class="addprogram_anket-course_lessons-item-main-name-lesson">' +
          lesson.teory.lessonName +
          '</p><div class="addprogram_anket-course_lessons-item-main-icons"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="#2CCD65"/><path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91696 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="#2CCD65"/></svg><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-change"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.625 15.75H16.125" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.125 10.02V12.75H6.86895L14.625 4.99054L11.8857 2.25L4.125 10.02Z" stroke="#A5AABE" stroke-width="1.5" stroke-linejoin="round"/></svg></button><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-delete"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0801 6.00026L4.92035 6.00004L4.49536 6.00003C3.89825 6.00001 3.4342 6.51989 3.50175 7.11317L4.34259 14.4975C4.40377 15.0504 4.66757 15.561 5.08308 15.9308C5.49859 16.3006 6.03636 16.5034 6.59259 16.5H11.4076C11.9638 16.5034 12.5016 16.3006 12.9171 15.9308C13.3326 15.561 13.5964 15.0504 13.6576 14.4975L14.4983 7.11331C14.5658 6.51998 14.1017 6.00009 13.5045 6.00019L13.0801 6.00026ZM12.1501 14.3325C12.1297 14.5168 12.0418 14.687 11.9033 14.8103C11.7648 14.9336 11.5855 15.0012 11.4001 15H6.59259C6.40718 15.0012 6.22793 14.9336 6.08942 14.8103C5.95092 14.687 5.86299 14.5168 5.84259 14.3325L5.08509 7.50004H12.9151L12.1501 14.3325ZM10.5001 13.5C10.699 13.5 10.8898 13.421 11.0304 13.2804C11.1711 13.1397 11.2501 12.949 11.2501 12.75V9.75004C11.2501 9.55113 11.1711 9.36036 11.0304 9.21971C10.8898 9.07906 10.699 9.00004 10.5001 9.00004C10.3012 9.00004 10.1104 9.07906 9.96977 9.21971C9.82911 9.36036 9.7501 9.55113 9.7501 9.75004V12.75C9.7501 12.949 9.82911 13.1397 9.96977 13.2804C10.1104 13.421 10.3012 13.5 10.5001 13.5ZM7.50009 13.5C7.69901 13.5 7.88977 13.421 8.03042 13.2804C8.17108 13.1397 8.25009 12.949 8.25009 12.75V9.75004C8.25009 9.55113 8.17108 9.36036 8.03042 9.21971C7.88977 9.07906 7.69901 9.00004 7.50009 9.00004C7.30118 9.00004 7.11042 9.07906 6.96976 9.21971C6.82911 9.36036 6.75009 9.55113 6.75009 9.75004V12.75C6.75009 12.949 6.82911 13.1397 6.96976 13.2804C7.11042 13.421 7.30118 13.5 7.50009 13.5Z" fill="#A5AABE"/><rect x="2.625" y="4.125" width="12.75" height="0.75" rx="0.375" stroke="#A5AABE" stroke-width="0.75"/><path d="M12 3.75V2.5C12 1.94772 11.5523 1.5 11 1.5H7C6.44772 1.5 6 1.94772 6 2.5V3.75" stroke="#A5AABE" stroke-width="1.5"/></svg></button></div></div></div>'
      );

      $(".btn--type-module").attr("disabled", false);
      $(".addprogram-anket-create-module-cancel").hide();
      $(".addprogram-anket-create-module-save").show();
      $(".create-module-task.teory input").val("");
      $(".create-module-task.teory").hide();
      $(".create-module-task.teory .input__file-button-text").text(
        "Загрузить документ"
      );

      $(".add-doc-to-create-lesson").children().remove();
      $(".add-doc-to-create-lesson-dop").children().remove();

      console.log(lesson);
    } else {
      $(".lesson-input-req").each(function () {
        if ($(this).val().length == 0) {
          if ($(this).hasClass("input__file")) {
            $(this).next().children().addClass("red");
          } else {
            $(this).addClass("redq");
          }
        } else {
          $(this).removeClass("redq");
          $(this).next().children().removeClass("red");
        }
      });
    }
  },
  checkStorage() {
    const category = localStorage.getItem("category");
    if (category) {
      $(".categoryInput").each(function () {
        if ($(this).val() === category) {
          $(this).prop("checked", true);
          $(".selectCategory").text($(this).attr("data-name"));
        }
      });
    }
  },
  changeStep(step) {
    $(".Stap" + step).fadeOut(300, function () {
      $(".Stap" + ++step).fadeIn(300, function () {
        if ($(".Stap4").is(":visible")) {
          $(".create-resume-form_left-list-item:nth-child(4)").addClass(
            "active"
          );
          $(
            ".create-resume-form_left-list-item:nth-child(4) .create-resume-form_left-list-item-indicator"
          ).addClass("active");
          $(
            ".create-resume-form_left-list-item:nth-child(3) .create-resume-form_left-list-item-indicator"
          )
            .addClass("done")
            .text("✓");
          $(".create-course_modules-group").addClass("hide");
        } else if ($(".Stap3").is(":visible")) {
          $(".create-resume-form_left-list-item:nth-child(3)").addClass(
            "active"
          );
          $(
            ".create-resume-form_left-list-item:nth-child(3) .create-resume-form_left-list-item-indicator"
          ).addClass("active");
          $(
            ".create-resume-form_left-list-item:nth-child(2) .create-resume-form_left-list-item-indicator"
          )
            .addClass("done")
            .text("✓");
        } else if ($(".Stap2").is(":visible")) {
          $(".create-resume-form_left-list-item:nth-child(2)").addClass(
            "active"
          );
          $(
            ".create-resume-form_left-list-item:nth-child(2) .create-resume-form_left-list-item-indicator"
          ).addClass("active");
          $(
            ".create-resume-form_left-list-item:nth-child(1) .create-resume-form_left-list-item-indicator"
          )
            .addClass("done")
            .text("✓");
          $(".addprogram_anket-save").attr("disabled", false);
        }
        localStorage.setItem("step", step);
      });
    });
  },
};
