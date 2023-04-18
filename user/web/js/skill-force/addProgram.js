import addFunctions from "./functions/addFunctions.js";

const categoryInput = $(".categoryInput");

addFunctions.checkStorage();

$(".addprogram_first_isnt-upload-list-item_btn-delete").on("click", () => {
  $(".addprogram-popup-delete").fadeIn(300);
});

$(".addprogram_first-type-item-btn").on("click", function () {
  $(".addprogram_first").fadeOut(0, () => {
    $(".addprogram_anket-course").fadeIn(0);
  });
});

var step = 0;

$(".btn--show-own-wey").on("click", function () {
  $(".own-wey-input, .save-category").show();
  $("#addNewCategory").removeAttr("hidden");
  $(this).hide();
  $(".create-resume-form_main_btns").fadeOut(1);
});

$(".sendActive").on("click", function () {
  $(".jq-selectbox__select.danger").removeClass("danger");
  $("#catToLink, .bown-wey-text, .save-category").fadeOut(1);
  $(".btn--show-own-wey, .create-resume-form_main_btns").fadeIn(1);
});

categoryInput.on("click", function () {
  $(".selectCategory").text($(this).attr("data-name")).removeClass("danger");
  $(".itemsCategory").attr("hidden", "");
  $(".create-resume-form_main_btns, .btn--show-own-wey").fadeIn(1);
});

$(".selectCategory").on("click", function () {
  $(".itemsCategory").removeAttr("hidden");
  $("#addNewCategory").attr("hidden", "");
});

$(".addprogram_anket-course-form-1").on("submit", function (e) {
  $.ajax({
    url: "/skill/teacher/add-category",
    type: "POST",
    dataType: "JSON",
    data: $(this).serialize(),
  }).done(function (response) {
    if (response.status) {
      addFunctions.changeStep(step);
      localStorage.setItem("category", response.id);
    } else {
      Swal.fire({
        icon: "error",
        title: "Ошибка",
        text: response.text,
      });
    }
  });
  e.preventDefault();
});

$(".btn--next").on("click", function () {
  let flag = true;
  if (step === 1) {
    categoryInput.each(function () {
      if ($(this).prop("checked")) {
        addFunctions.changeStep(step);
        localStorage.setItem("category", $(this).val());
        flag = false;
        return false;
      }
    });
    if (flag) $(".selectCategory").addClass("danger");
    flag = true;
  }
});

$(".addprogram_anket-course-form-2").on("submit", function (e) {
  $.ajax({
    url: "",
    method: "POST",
    data: $(this).serialize(),
  }).done(function () {
    addFunctions.changeStep(step);
  });
  e.preventDefault();
});

$(".addprogram_anket-course-form-3").on("submit", function (e) {
  $.ajax({
    url: "",
    method: "POST",
    data: $(this).serialize(),
    beforeSend: function () {},
  }).done(function () {
    addFunctions.changeStep(step);
  });
  e.preventDefault();
});

$(".addprogram_anket-course-form-4").on("submit", function (e) {
  $.ajax({
    url: "",
    method: "POST",
    data: $(this).serialize(),
    //Это нужно поставить соответственно не в beforeSend, а в done
    beforeSend: function () {
      $(".corse-upload-done-popup").show();
      setTimeout(() => {
        location.reload();
      }, 2000);
    },
  });
  e.preventDefault();
});

$(".addprogram_anket-upload").click(function () {
  $(".addprogram_anket-course-form-4").submit();
});

$(".fileWrapper").on("change", ".input__file", function () {
  console.log($(this));
  if ($(this).val().length > 0) $(this).next().text("Загружено");
});

$(".btn--add-prepod").on("click", addFunctions.appInputFile());

$(".addprogram-anket-create-module").on("click", function () {
  $(this).hide();
  $(".addprogram-anket-create-module-block").show();
});

$(".btn--type-module").on("click", function () {
  $(".btn--type-module").attr("disabled", true);
  $(this).attr("disabled", false);
  $(".addprogram-anket-create-module-cancel").show();
  $(".addprogram-anket-create-module-save").hide();
  if ($(this).hasClass("teory")) {
    $(".create-module-task.teory").show();
  } else if ($(this).hasClass("practice")) {
    $(".create-module-task.practice").show();
  } else if ($(this).hasClass("test")) {
    $(".create-module-task.test").show();
  }
});

$(".addprogram-anket-create-module-cancel").on("click", function () {
  $(".btn--type-module").attr("disabled", false);
  $(".addprogram-anket-create-module-cancel").hide();
  $(".addprogram-anket-create-module-save").show();

  if ($(".create-module-task.teory").is(":visible")) {
    $(".create-module-task.teory input").val("");
    $(".create-module-task.teory").hide();
    $(".add-doc-to-create-lesson").children().remove();
    $(".add-doc-to-create-lesson-dop").children().remove();
    $(".create-module-task.teory .input__file-button-text").text(
      "Загрузить документ"
    );
  } else if ($(".create-module-task.practice").is(":visible")) {
    $(".create-module-task.practice input").val("");
    $(".create-module-task.practice").hide();
    $(".add-doc-to-create-lesson2").children().remove();
    $(".create-module-task.practice .input__file-button-text").text(
      "Загрузить документ"
    );
  } else if ($(".create-module-task.test").is(":visible")) {
    $(".create-module-task.test input").val("");
    $(".create-module-task.test").hide();
  }
});

var countDoc = 1;
$(".addprogram-anket-create-module-add-document").on("click", function () {
  countDoc++;
  $(".add-doc-to-create-lesson").append(
    '<h4 class="create-resume-form_main-second-title">Материалы к лекции <span>(инструкции, лекции, чек-листы и т.п.)</span></h4><input style="margin-bottom: 12px;" placeholder="Название документа" type="text" name="document-to-lesson-name[]" class="input-t create-resume-form-input-t"><div class="input__wrapper"><input name="document-to-lesson[]" type="file"  id="input__file-3-2-' +
      countDoc +
      '" class="input input__file"><label for="input__file-3-2-' +
      countDoc +
      '" class="input__file-button"><span class="input__file-button-text">Загрузить документ</span></label></div>'
  );
});

var countDocDop = 1;
$(".addprogram-anket-create-module-add-document-dop").on("click", function () {
  countDocDop++;
  $(".add-doc-to-create-lesson-dop").append(
    '<h4 class="create-resume-form_main-second-title">Дополнительные материалы к лекции</h4><input style="margin-bottom: 12px;" placeholder="Название документа" type="text" name="document-to-lesson-name-dop[]" class="input-t create-resume-form-input-t"><div class="input__wrapper"><input name="document-to-lesson-dop[]" type="file"  id="input__file-3-3-' +
      countDocDop +
      '" class="input input__file"><label for="input__file-3-3-' +
      countDocDop +
      '" class="input__file-button"><span class="input__file-button-text">Загрузить документ</span></label></div>'
  );
});

var countDocDop2 = 1;
$(".addprogram-anket-create-module-add-document2").on("click", function () {
  countDocDop2++;
  $(".add-doc-to-create-lesson2").append(
    '<h4 class="create-resume-form_main-second-title">Материалы к заданию <span>(инструкции, лекции, чек-листы и т.п.)</span></h4><input style="margin-bottom: 12px;" placeholder="Название документа" type="text" name="document-to-lesson-name[]" class="input-t create-resume-form-input-t"><div class="input__wrapper"><input name="document-to-lesson" type="file"  id="input__file-4-1-' +
      countDocDop2 +
      '" class="input input__file"><label for="input__file-4-1-' +
      countDocDop2 +
      '" class="input__file-button"><span class="input__file-button-text">Загрузить документ</span></label></div>'
  );
});

$(".addprogram-anket-type-answer-radio").on("click", function () {
  $(".addprogram-anket-type-answer-radio").removeClass("active");
  $(this).addClass("active");
});

var lesson = {};

$(".addprogram-anket-create-lesson-save.teory").on(
  "click",
  addFunctions.addProgramm()
);

var practice = {};

$(".addprogram-anket-create-lesson-save.practice").on("click", function () {
  if (
    $('.create-module-task.practice input[name="lesson-name"]').val().length !=
      0 &&
    $('.create-module-task.practice input[name="lesson-describe"]').val()
      .length != 0 &&
    $(
      '.create-module-task.practice input[name="document-to-lesson-name[]"]'
    ).val().length != 0 &&
    $('.create-module-task.practice input[name="document-to-lesson[]"]').val()
      .length != 0
  ) {
    $(".lesson-input-req").removeClass("redq");
    $(".input__file-button-text").removeClass("red");

    var practiceName = $(
        '.create-module-task.practice input[name="lesson-name"]'
      ),
      practiceDescribe = $(
        '.create-module-task.practice input[name="lesson-describe"]'
      ),
      practiceDocName = $(
        '.create-module-task.practice input[name="document-to-lesson-name[]"]'
      ),
      practiceDocLink = $(
        '.create-module-task.practice input[name="document-to-lesson[]"]'
      ),
      arr = [],
      practiceDocNameArr = [],
      practiceDocLinkArr = [];

    practiceDocName.each(function () {
      practiceDocNameArr.push($(this).val());
    });
    practiceDocLink.each(function () {
      practiceDocLinkArr.push($(this).val());
    });
    arr.practiceName = practiceName.val();
    arr.practiceDescribe = practiceDescribe.val();
    arr.practiceDocName = practiceDocNameArr;
    arr.practiceDocLink = practiceDocLinkArr;
    practice.pract = arr;

    $(".addprogram_anket-course_lessons").append(
      '<div class="addprogram_anket-course_lessons-item"><p class="addprogram_anket-course_lessons-item-name">Занятие №1</p><div class="addprogram_anket-course_lessons-item-main"><p class="addprogram_anket-course_lessons-item-main-name-lesson">' +
        practice.pract.practiceName +
        '</p><div class="addprogram_anket-course_lessons-item-main-icons"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="#2CCD65"/><path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91696 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="#2CCD65"/></svg><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-change"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.625 15.75H16.125" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.125 10.02V12.75H6.86895L14.625 4.99054L11.8857 2.25L4.125 10.02Z" stroke="#A5AABE" stroke-width="1.5" stroke-linejoin="round"/></svg></button><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-delete"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0801 6.00026L4.92035 6.00004L4.49536 6.00003C3.89825 6.00001 3.4342 6.51989 3.50175 7.11317L4.34259 14.4975C4.40377 15.0504 4.66757 15.561 5.08308 15.9308C5.49859 16.3006 6.03636 16.5034 6.59259 16.5H11.4076C11.9638 16.5034 12.5016 16.3006 12.9171 15.9308C13.3326 15.561 13.5964 15.0504 13.6576 14.4975L14.4983 7.11331C14.5658 6.51998 14.1017 6.00009 13.5045 6.00019L13.0801 6.00026ZM12.1501 14.3325C12.1297 14.5168 12.0418 14.687 11.9033 14.8103C11.7648 14.9336 11.5855 15.0012 11.4001 15H6.59259C6.40718 15.0012 6.22793 14.9336 6.08942 14.8103C5.95092 14.687 5.86299 14.5168 5.84259 14.3325L5.08509 7.50004H12.9151L12.1501 14.3325ZM10.5001 13.5C10.699 13.5 10.8898 13.421 11.0304 13.2804C11.1711 13.1397 11.2501 12.949 11.2501 12.75V9.75004C11.2501 9.55113 11.1711 9.36036 11.0304 9.21971C10.8898 9.07906 10.699 9.00004 10.5001 9.00004C10.3012 9.00004 10.1104 9.07906 9.96977 9.21971C9.82911 9.36036 9.7501 9.55113 9.7501 9.75004V12.75C9.7501 12.949 9.82911 13.1397 9.96977 13.2804C10.1104 13.421 10.3012 13.5 10.5001 13.5ZM7.50009 13.5C7.69901 13.5 7.88977 13.421 8.03042 13.2804C8.17108 13.1397 8.25009 12.949 8.25009 12.75V9.75004C8.25009 9.55113 8.17108 9.36036 8.03042 9.21971C7.88977 9.07906 7.69901 9.00004 7.50009 9.00004C7.30118 9.00004 7.11042 9.07906 6.96976 9.21971C6.82911 9.36036 6.75009 9.55113 6.75009 9.75004V12.75C6.75009 12.949 6.82911 13.1397 6.96976 13.2804C7.11042 13.421 7.30118 13.5 7.50009 13.5Z" fill="#A5AABE"/><rect x="2.625" y="4.125" width="12.75" height="0.75" rx="0.375" stroke="#A5AABE" stroke-width="0.75"/><path d="M12 3.75V2.5C12 1.94772 11.5523 1.5 11 1.5H7C6.44772 1.5 6 1.94772 6 2.5V3.75" stroke="#A5AABE" stroke-width="1.5"/></svg></button></div></div></div>'
    );

    $(".btn--type-module").attr("disabled", false);
    $(".addprogram-anket-create-module-cancel").hide();
    $(".addprogram-anket-create-module-save").show();
    $(".create-module-task.practice input").val("");
    $(".create-module-task.practice").hide();
    $(".create-module-task.practice .input__file-button-text").text(
      "Загрузить документ"
    );

    $(".add-doc-to-create-lesson2").children().remove();

    console.log(practice);
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
});

$('input[name="test-type-answer"]').on("change", function () {
  $(".test-type-answer_group input").val("");
  $(".test-type-answer_group .input__file-button-text").text(
    "Загрузить ответ-изображение"
  );

  if ($(this).is(":checked") && $(this).hasClass("test-type-answer-1")) {
    $(".test-type-answer_group").hide();
    $(".test-type-answer_group-1").show();
  } else if ($(this).is(":checked") && $(this).hasClass("test-type-answer-2")) {
    $(".test-type-answer_group").hide();
    $(".test-type-answer_group-2").show();
  } else if ($(this).is(":checked") && $(this).hasClass("test-type-answer-3")) {
    $(".test-type-answer_group").hide();
    $(".test-type-answer_group-3").show();
  } else if ($(this).is(":checked") && $(this).hasClass("test-type-answer-4")) {
    $(".test-type-answer_group").hide();
    $(".test-type-answer_group-4").show();
  }
});

var answer2Count = 4;
$(".test-type-answer_group-2_answer-addmore").on("click", function () {
  answer2Count++;
  $(".test-type-answer_group-2_answer-more").append(
    '<div class="test-type-answer_group-2_answer"><div class="test-type-answer_group-2_answer_top"><div class="test-type-answer_group-2_answer_top_left"><p class="test-type-answer_group-2_answer_top_left-number">' +
      answer2Count +
      '</p><input placeholder="Введите текст" type="text" name="answer-variation[]" class="answer-variation-input"></div><label class="answer-variation-rigth-label">Правильный<input class="answer-variation-rigth" type="checkbox" name="answer-variation-rigth[]" value="Правильный"></label></div><div class="input__wrapper" style="margin-bottom: 0px;"><input name="answer-variation-image[]" type="file" id="input__file-6-' +
      answer2Count +
      '" class="input input__file"><label for="input__file-6-' +
      answer2Count +
      '" class="input__file-button"><span class="input__file-button-text">Загрузить ответ-изображение</span></label></div></div>'
  );

  checkboxLabel();
});

var answer3Count = 4;
$(".test-type-answer_group-3_answer-addmore").on("click", function () {
  answer3Count++;
  $(".test-type-answer_group-3_answer-more").append(
    '<div class="test-type-answer_group-2_answer"><div class="test-type-answer_group-2_answer_top"><div class="test-type-answer_group-2_answer_top_left"><p class="test-type-answer_group-2_answer_top_left-number">' +
      answer3Count +
      '</p><input placeholder="Введите текст" type="text" name="answer-streamline[]" class="answer-variation-input"></div></div><div class="input__wrapper" style="margin-bottom: 0px;"><input name="answer-streamline-image[]" type="file" id="input__file-7-' +
      answer3Count +
      '" class="input input__file"><label for="input__file-7-' +
      answer3Count +
      '" class="input__file-button"><span class="input__file-button-text">Загрузить ответ-изображение</span></label></div></div>'
  );

  checkboxLabel();
});

var answer4Count = 4;
$(".test-type-answer_group-4_answer-addmore").on("click", function () {
  answer4Count++;
  $(".test-type-answer_group-4_answer-more").append(
    '<div class="test-type-answer_group-2_answer"><div class="test-type-answer_group-2_answer_top"><div class="test-type-answer_group-2_answer_top_left"><p class="test-type-answer_group-2_answer_top_left-number">' +
      answer4Count +
      '</p><input placeholder="Введите текст" type="text" name="answer-match-from[]" class="answer-variation-input"></div></div></div>'
  );

  checkboxLabel();
});

var answer5Count = 4;
$(".test-type-answer_group-5_answer-addmore").on("click", function () {
  answer5Count++;
  $(".test-type-answer_group-5_answer-more").append(
    '<div class="test-type-answer_group-2_answer"><div class="test-type-answer_group-2_answer_top"><div class="test-type-answer_group-2_answer_top_left"><p class="test-type-answer_group-2_answer_top_left-number">' +
      answer5Count +
      '</p><input placeholder="Введите текст" type="text" name="answer-match-to[]" class="answer-variation-input"></div><input min="1" type="number" name="answer-match-to-num[]" class="answer-match-to-num-input-number"></div><div class="input__wrapper" style="margin-bottom: 0px;"><input name="answer-match-to-image[]" type="file"  id="input__file-8-' +
      answer5Count +
      '" class="input input__file"><label for="input__file-8-' +
      answer5Count +
      '" class="input__file-button"><span class="input__file-button-text">Загрузить ответ-изображение</span></label></div></div>'
  );

  checkboxLabel();
});

function checkboxLabel() {
  $(".answer-variation-rigth").on("change", function () {
    if ($(this).prop("checked") == true) {
      $(this).parent().addClass("checked");
    } else {
      $(this).parent().removeClass("checked");
    }
  });
}

checkboxLabel();

var allQuestionsCount = 0;
$(".test-type-answer_group-save").on("click", function () {
  if (
    $(this).parent().parent().find('input[name="question-text[]"]').val()
      .length > 0
  ) {
    allQuestionsCount++;
    $(this)
      .parent()
      .parent()
      .find('input[name="question-text[]"]')
      .removeClass("red");
    $(this).parent().parent().hide();
    var questionName = $(this)
      .parent()
      .parent()
      .find(".addprogram-anket-type-answer-radio.active input")
      .val();
    $(".addpr-ank-c-test-questions-blocks").append(
      '<div class="addprogram_anket-course_lessons-item"><p class="addprogram_anket-course_lessons-item-name">Вопрос №' +
        allQuestionsCount +
        '</p><div class="addprogram_anket-course_lessons-item-main"><p class="addprogram_anket-course_lessons-item-main-name-lesson">' +
        questionName +
        '</p><div class="addprogram_anket-course_lessons-item-main-icons"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="#2CCD65"/><path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91696 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="#2CCD65"/></svg><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-change"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.625 15.75H16.125" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.125 10.02V12.75H6.86895L14.625 4.99054L11.8857 2.25L4.125 10.02Z" stroke="#A5AABE" stroke-width="1.5" stroke-linejoin="round"/></svg></button><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-delete"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0801 6.00026L4.92035 6.00004L4.49536 6.00003C3.89825 6.00001 3.4342 6.51989 3.50175 7.11317L4.34259 14.4975C4.40377 15.0504 4.66757 15.561 5.08308 15.9308C5.49859 16.3006 6.03636 16.5034 6.59259 16.5H11.4076C11.9638 16.5034 12.5016 16.3006 12.9171 15.9308C13.3326 15.561 13.5964 15.0504 13.6576 14.4975L14.4983 7.11331C14.5658 6.51998 14.1017 6.00009 13.5045 6.00019L13.0801 6.00026ZM12.1501 14.3325C12.1297 14.5168 12.0418 14.687 11.9033 14.8103C11.7648 14.9336 11.5855 15.0012 11.4001 15H6.59259C6.40718 15.0012 6.22793 14.9336 6.08942 14.8103C5.95092 14.687 5.86299 14.5168 5.84259 14.3325L5.08509 7.50004H12.9151L12.1501 14.3325ZM10.5001 13.5C10.699 13.5 10.8898 13.421 11.0304 13.2804C11.1711 13.1397 11.2501 12.949 11.2501 12.75V9.75004C11.2501 9.55113 11.1711 9.36036 11.0304 9.21971C10.8898 9.07906 10.699 9.00004 10.5001 9.00004C10.3012 9.00004 10.1104 9.07906 9.96977 9.21971C9.82911 9.36036 9.7501 9.55113 9.7501 9.75004V12.75C9.7501 12.949 9.82911 13.1397 9.96977 13.2804C10.1104 13.421 10.3012 13.5 10.5001 13.5ZM7.50009 13.5C7.69901 13.5 7.88977 13.421 8.03042 13.2804C8.17108 13.1397 8.25009 12.949 8.25009 12.75V9.75004C8.25009 9.55113 8.17108 9.36036 8.03042 9.21971C7.88977 9.07906 7.69901 9.00004 7.50009 9.00004C7.30118 9.00004 7.11042 9.07906 6.96976 9.21971C6.82911 9.36036 6.75009 9.55113 6.75009 9.75004V12.75C6.75009 12.949 6.82911 13.1397 6.96976 13.2804C7.11042 13.421 7.30118 13.5 7.50009 13.5Z" fill="#A5AABE"/><rect x="2.625" y="4.125" width="12.75" height="0.75" rx="0.375" stroke="#A5AABE" stroke-width="0.75"/><path d="M12 3.75V2.5C12 1.94772 11.5523 1.5 11 1.5H7C6.44772 1.5 6 1.94772 6 2.5V3.75" stroke="#A5AABE" stroke-width="1.5"/></svg></button></div></div></div>'
    );

    $(this)
      .parent()
      .parent()
      .find(".addpr-ank-c-test-quest-questions-input")
      .val("");
    $(this).parent().parent().find(".test-type-answer_group input").val("");
    $(this)
      .parent()
      .parent()
      .find(".input__file-button-text")
      .text("Загрузить ответ-изображение");
    $(this)
      .parent()
      .parent()
      .find(".input__file-button-text-name")
      .text("Загрузить изображение к вопросу");
    $(".addprogram-anket-type-answer-radio").removeClass("active");
    $(".test-type-answer_group-2_answer-more").children().remove();
    $(".test-type-answer_group-3_answer-more").children().remove();
    $(".test-type-answer_group-4_answer-more").children().remove();
    $(".test-type-answer_group-5_answer-more").children().remove();
    $(".test-type-answer_group").hide();
    $(this)
      .parent()
      .parent()
      .find(".answer-variation-rigth-label")
      .removeClass("checked");
    $(".addprogram-anket-create-module-add-question-b").show();
  } else {
    $(".addpr-ank-c-test-quest-questions-input").addClass("red");
  }
});

$(".addprogram-anket-create-module-add-question").on("click", function () {
  $(".addpr-ank-c-test-quest").show();
  $(".addprogram-anket-create-module-add-question-b").hide();
});

$(".addprogram-anket-create-lesson-save.test").on("click", function () {
  if (
    $('.create-module-task.test input[name="lesson-name"]').val().length != 0
  ) {
    $(".addprogram_anket-course_lessons").append(
      '<div class="addprogram_anket-course_lessons-item"><p class="addprogram_anket-course_lessons-item-name">Тест №1</p><div class="addprogram_anket-course_lessons-item-main"><p class="addprogram_anket-course_lessons-item-main-name-lesson">' +
        $('.create-module-task.test input[name="lesson-name"]').val() +
        '</p><div class="addprogram_anket-course_lessons-item-main-icons"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="#2CCD65"/><path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91696 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="#2CCD65"/></svg><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-change"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.625 15.75H16.125" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.125 10.02V12.75H6.86895L14.625 4.99054L11.8857 2.25L4.125 10.02Z" stroke="#A5AABE" stroke-width="1.5" stroke-linejoin="round"/></svg></button><button type="button" class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-delete"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0801 6.00026L4.92035 6.00004L4.49536 6.00003C3.89825 6.00001 3.4342 6.51989 3.50175 7.11317L4.34259 14.4975C4.40377 15.0504 4.66757 15.561 5.08308 15.9308C5.49859 16.3006 6.03636 16.5034 6.59259 16.5H11.4076C11.9638 16.5034 12.5016 16.3006 12.9171 15.9308C13.3326 15.561 13.5964 15.0504 13.6576 14.4975L14.4983 7.11331C14.5658 6.51998 14.1017 6.00009 13.5045 6.00019L13.0801 6.00026ZM12.1501 14.3325C12.1297 14.5168 12.0418 14.687 11.9033 14.8103C11.7648 14.9336 11.5855 15.0012 11.4001 15H6.59259C6.40718 15.0012 6.22793 14.9336 6.08942 14.8103C5.95092 14.687 5.86299 14.5168 5.84259 14.3325L5.08509 7.50004H12.9151L12.1501 14.3325ZM10.5001 13.5C10.699 13.5 10.8898 13.421 11.0304 13.2804C11.1711 13.1397 11.2501 12.949 11.2501 12.75V9.75004C11.2501 9.55113 11.1711 9.36036 11.0304 9.21971C10.8898 9.07906 10.699 9.00004 10.5001 9.00004C10.3012 9.00004 10.1104 9.07906 9.96977 9.21971C9.82911 9.36036 9.7501 9.55113 9.7501 9.75004V12.75C9.7501 12.949 9.82911 13.1397 9.96977 13.2804C10.1104 13.421 10.3012 13.5 10.5001 13.5ZM7.50009 13.5C7.69901 13.5 7.88977 13.421 8.03042 13.2804C8.17108 13.1397 8.25009 12.949 8.25009 12.75V9.75004C8.25009 9.55113 8.17108 9.36036 8.03042 9.21971C7.88977 9.07906 7.69901 9.00004 7.50009 9.00004C7.30118 9.00004 7.11042 9.07906 6.96976 9.21971C6.82911 9.36036 6.75009 9.55113 6.75009 9.75004V12.75C6.75009 12.949 6.82911 13.1397 6.96976 13.2804C7.11042 13.421 7.30118 13.5 7.50009 13.5Z" fill="#A5AABE"/><rect x="2.625" y="4.125" width="12.75" height="0.75" rx="0.375" stroke="#A5AABE" stroke-width="0.75"/><path d="M12 3.75V2.5C12 1.94772 11.5523 1.5 11 1.5H7C6.44772 1.5 6 1.94772 6 2.5V3.75" stroke="#A5AABE" stroke-width="1.5"/></svg></button></div></div></div>'
    );

    $(".btn--type-module").attr("disabled", false);
    $(".addprogram-anket-create-module-cancel").hide();
    $(".addprogram-anket-create-module-save").show();
    $('.create-module-task.test input[name="lesson-name"]').val("");
    $('.create-module-task.test input[name="retest-count"]').val("");
    $('.create-module-task.test input[name="autocheck-lesson"]').prop(
      "checked",
      false
    );
    $(
      ".create-module-task.test .create-resume-form_main-input-group-item-label .jq-checkbox"
    ).removeClass("checked");
    $(".create-module-task.test").hide();
    $(".addprogram-anket-create-module-add-question-b").hide();
    $(".addpr-ank-c-test-quest").show();
    $(".addpr-ank-c-test-questions-blocks").children().remove();
  } else {
    $(".lesson-input-req").each(function () {
      if ($(this).val().length == 0) {
        $(this).addClass("redq");
      } else {
        $(this).removeClass("redq");
      }
    });
  }
});

$(".addprogram-anket-create-lesson-save").on("click", function () {
  $(".addprogram-anket-create-module-save").attr("disabled", false);
});

$('.addprogram-anket-course-chack-l input[name="check-lesson-type"]').on(
  "change",
  function () {
    if ($(this).is(":checked")) {
      $(".radio-checkbox-label").removeClass("active");
      $(this).parent().addClass("active");
      $(".btn--addprogram_anket-course-form-4").attr("disabled", false);
    } else {
      $(".radio-checkbox-label").removeClass("active");
      $(".btn--addprogram_anket-course-form-4").attr("disabled", true);
    }

    if ($(this).is(":checked") && $(this).hasClass("check-lesson-type-2")) {
      $(".check-lesson-type-3_block").hide();
      $(".check-lesson-type-2_block").show();
      $(
        ".check-lesson-type-2_block input, .check-lesson-type-2_block select"
      ).attr("disabled", false);
      $(
        ".check-lesson-type-3_block input, .check-lesson-type-3_block select"
      ).attr("disabled", true);
    } else if (
      $(this).is(":checked") &&
      $(this).hasClass("check-lesson-type-3")
    ) {
      $(".check-lesson-type-2_block").hide();
      $(".check-lesson-type-3_block").show();
      $(
        ".check-lesson-type-3_block input, .check-lesson-type-3_block select"
      ).attr("disabled", false);
      $(
        ".check-lesson-type-2_block input, .check-lesson-type-2_block select"
      ).attr("disabled", true);
    } else if (
      $(this).is(":checked") &&
      $(this).hasClass("check-lesson-type-1")
    ) {
      $(".check-lesson-type_block").hide();
      $(
        ".check-lesson-type-2_block input, .check-lesson-type-2_block select"
      ).attr("disabled", true);
      $(
        ".check-lesson-type-3_block input, .check-lesson-type-3_block select"
      ).attr("disabled", true);
    }
  }
);

$(".check-lesson-refine-delete").on("click", function () {
  $(".check-lesson-type-2_block_top-item.orange").addClass("disabled");
  $(".check-lesson-refine-block").hide();
  $(".check-lesson-refine-block input, .check-lesson-refine-block select").attr(
    "disabled",
    true
  );
  $(".check-lesson-refine-add").show();
  $(this).hide();
});

$(".check-lesson-refine-add").on("click", function () {
  $(".check-lesson-type-2_block_top-item.orange").removeClass("disabled");
  $(".check-lesson-refine-block").show();
  $(".check-lesson-refine-block input, .check-lesson-refine-block select").attr(
    "disabled",
    false
  );
  $(".check-lesson-refine-delete").show();
  $(this).hide();
});

$(
  '.check-lesson-type-3_block-group input[name="check-lesson-grading-format"]'
).on("change", function () {
  if ($(this).is(":checked")) {
    $(".check-lesson-type-3_block-group-item").removeClass("checked");
    $(this).parent().addClass("checked");
  } else {
    $(".check-lesson-type-3_block-group-item").removeClass("checked");
  }

  if (
    $(this).is(":checked") &&
    $(this).hasClass("check-lesson-grading-format-1")
  ) {
    $(".check-lesson-grading-format-2_block").hide();
    $(".check-lesson-grading-format-1_block").show();
    $(
      ".check-lesson-grading-format-1_block input, .check-lesson-grading-format-1_block select"
    ).attr("disabled", false);
    $(
      ".check-lesson-grading-format-2_block input, .check-lesson-grading-format-2_block select"
    ).attr("disabled", true);
  } else if (
    $(this).is(":checked") &&
    $(this).hasClass("check-lesson-grading-format-2")
  ) {
    $(".check-lesson-grading-format-1_block").hide();
    $(".check-lesson-grading-format-2_block").show();
    $(
      ".check-lesson-grading-format-2_block input, .check-lesson-grading-format-2_block select"
    ).attr("disabled", false);
    $(
      ".check-lesson-grading-format-1_block input, .check-lesson-grading-format-1_block select"
    ).attr("disabled", true);
  }
});

$(".check-lesson-grading-format-1_block_test-item-btn").on(
  "click",
  function () {
    $(this).toggleClass("active");
    $(this).next().toggleClass("active");
  }
);

$(".check-lesson-grading-format-1_block--btn").on("click", function () {
  $(this).parent().find(".check-lesson-grading-format-1_block_test").show();
  $(this).parent().find(".check-lesson-grading-format-1_block--btn-del").show();
  $(this).hide();
});
$(".check-lesson-grading-format-1_block--btn-del").on("click", function () {
  $(this).parent().find(".check-lesson-grading-format-1_block_test").hide();
  $(this)
    .parent()
    .find(".check-lesson-grading-format-1_block_test input")
    .val("");
  $(this).parent().find(".check-lesson-grading-format-1_block--btn").show();
  $(this).hide();
});

$(".create-resume-form_main").on(
  "click",
  ".check-lesson-grading-format-2_block_moduls-item-btn",
  function () {
    $(this).toggleClass("active");
  }
);

$('.create-course_check-person input[name="create-course_check-person"]').on(
  "change",
  function () {
    if ($(this).is(":checked")) {
      $(".create-course_check-person-label").removeClass("active");
      $(this).parent().addClass("active");
      $(".btn--addprogram_anket-course-form-5").attr("disabled", false);
    } else {
      $(".check-lesson-type-3_block-group-item").removeClass("checked");
      $(".btn--addprogram_anket-course-form-5").attr("disabled", true);
    }

    if (
      $(this).is(":checked") &&
      $(this).hasClass("create-course_check-person-1")
    ) {
      $(".create-course_check_block").hide();
    } else if (
      $(this).is(":checked") &&
      $(this).hasClass("create-course_check-person-2")
    ) {
      $(".create-course_check_block").show();
      $(
        ".check-lesson-grading-format-2_block input, .check-lesson-grading-format-2_block select"
      ).attr("disabled", false);
      $(
        ".check-lesson-grading-format-1_block input, .check-lesson-grading-format-1_block select"
      ).attr("disabled", true);
    }
  }
);

function assistSave() {
  $(".create-course_check_block-assist-save").on("click", function () {
    if (
      $(
        '.create-course_check_block-add-assistents_block input[name="assistent-name"]'
      ).val().length > 0 &&
      $(
        '.create-course_check_block-add-assistents_block input[name="assistent-email"]'
      ).val().length > 0
    ) {
      $(
        ".create-course_check_block-add-assistents_block .lesson-input-req"
      ).removeClass("redq");
      var moduls = $(
        ".create-course_check_block-add-assistents_block .check-lesson-grading-format-2_block_moduls"
      ).html();
      var name = $(
        '.create-course_check_block-add-assistents_block input[name="assistent-name"]'
      ).val();
      var email = $(
        '.create-course_check_block-add-assistents_block input[name="assistent-email"]'
      ).val();
      $(".create-course_check_block-assistents_block").append(
        '<div class="create-course_check_block-assistents_block-item"><div class="create-course_check_block-assistents_block-item_top"><div class="create-course_check_block-assistents_block-item_top_left"><p class="create-course_check_block-assistents_block-item_top_left-name">' +
          name +
          '</p><p class="create-course_check_block-assistents_block-item_top_left-email">' +
          email +
          '</p></div><button type="button" class="create-course_check_block-assistents_block-item-delete"><svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.2598 6.00026L5.10004 6.00004L4.67505 6.00003C4.07794 6.00001 3.61389 6.51989 3.68144 7.11317L4.52228 14.4975C4.58346 15.0504 4.84726 15.561 5.26277 15.9308C5.67828 16.3006 6.21605 16.5034 6.77228 16.5H11.5873C12.1435 16.5034 12.6813 16.3006 13.0968 15.9308C13.5123 15.561 13.7761 15.0504 13.8373 14.4975L14.6779 7.11331C14.7455 6.51998 14.2814 6.00009 13.6842 6.00019L13.2598 6.00026ZM12.3298 14.3325C12.3094 14.5168 12.2215 14.687 12.083 14.8103C11.9444 14.9336 11.7652 15.0012 11.5798 15H6.77228C6.58687 15.0012 6.40761 14.9336 6.26911 14.8103C6.13061 14.687 6.04267 14.5168 6.02228 14.3325L5.26478 7.50004H13.0948L12.3298 14.3325ZM10.6798 13.5C10.8787 13.5 11.0695 13.421 11.2101 13.2804C11.3508 13.1397 11.4298 12.949 11.4298 12.75V9.75004C11.4298 9.55113 11.3508 9.36036 11.2101 9.21971C11.0695 9.07906 10.8787 9.00004 10.6798 9.00004C10.4809 9.00004 10.2901 9.07906 10.1495 9.21971C10.0088 9.36036 9.92978 9.55113 9.92978 9.75004V12.75C9.92978 12.949 10.0088 13.1397 10.1495 13.2804C10.2901 13.421 10.4809 13.5 10.6798 13.5ZM7.67978 13.5C7.87869 13.5 8.06946 13.421 8.21011 13.2804C8.35076 13.1397 8.42978 12.949 8.42978 12.75V9.75004C8.42978 9.55113 8.35076 9.36036 8.21011 9.21971C8.06946 9.07906 7.87869 9.00004 7.67978 9.00004C7.48087 9.00004 7.2901 9.07906 7.14945 9.21971C7.0088 9.36036 6.92978 9.55113 6.92978 9.75004V12.75C6.92978 12.949 7.0088 13.1397 7.14945 13.2804C7.2901 13.421 7.48087 13.5 7.67978 13.5Z" fill="#A5AABE"/><rect x="2.80469" y="4.125" width="12.75" height="0.75" rx="0.375" stroke="#A5AABE" stroke-width="0.75"/><path d="M12.1797 3.75V2.5C12.1797 1.94772 11.732 1.5 11.1797 1.5H7.17969C6.6274 1.5 6.17969 1.94772 6.17969 2.5V3.75" stroke="#A5AABE" stroke-width="1.5"/></svg></button></div>' +
          moduls +
          "</div>"
      );
      $(".create-course_check_block-add-assistents_block").children().remove();
      $(".create-course_check_block-assist-add").addClass("active");
    } else {
      $(
        ".create-course_check_block-add-assistents_block .lesson-input-req"
      ).each(function () {
        if ($(this).val().length > 0) {
          $(this).removeClass("redq");
        } else {
          $(this).addClass("redq");
        }
      });
    }
    assistSave();
    assistCancel();
    assistDelete();
  });
}
assistSave();

function assistCancel() {
  $(".create-course_check_block-assist-cancel").on("click", function () {
    $(".create-course_check_block-add-assistents_block").children().remove();
    $(".create-course_check_block-assist-add").addClass("active");
    assistSave();
    assistDelete();
  });
}
assistCancel();
$(".create-course_check_block-assist-add").on("click", function () {
  $(".create-course_check_block-add-assistents_block").append(
    '<h3 class="create-module-task-stt">Обязательно</h3><h4 class="create-resume-form_main-second-title">Укажите данные ассистента</h4><input  placeholder="Фамилия имя" type="text" name="assistent-name" class="input-t create-resume-form-input-t lesson-input-req"><h4 class="create-resume-form_main-second-title">Укажите электронную почту ассистента <br> <span>После технической модерации курса на указанную почту будет отправлено приглашение для регистрации на платформе и проверки указанных заданийАссистенту необходимо пройти по ссылке и принять приглашение в течение 3 днейЕсли ассистент не примет приглашение в указанный срок, закрепленные за ним задания будут перенаправлены для проверки вами</span></h4><input  placeholder="mail@mail.ru" type="email" name="assistent-email" class="input-t create-resume-form-input-t lesson-input-req"><h4 class="create-resume-form_main-second-title">Укажите задания, которые будет проверять ассистент<br><span>Выберите задания, которые хотите заркепить за ассистентом</span></h4><div class="check-lesson-grading-format-2_block_moduls"><div class="check-lesson-grading-format-2_block_moduls-item"><button type="button" class="check-lesson-grading-format-2_block_moduls-item-btn">Модуль 1 «Основы продаж»</button><div class="check-lesson-grading-format-2_block_moduls-item_main"><div class="check-lesson-grading-format-2_block_moduls-item_main_conainer"><div class="check-lesson-grading-format-2_block_moduls-item_main-item"><p class="check-lesson-grading-format-2_block_moduls-item_main-item-text">Задание №1</p><label class="create-course_check_block-label"><span>Основы</span><input class="input-hide" type="checkbox" name="assistent-must-check[]" value="checked"><div class="create-course_check_block-label_right"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM1.2309 8.00031C1.2309 11.7389 4.26159 14.7695 8.00013 14.7695C11.7387 14.7695 14.7694 11.7389 14.7694 8.00031C14.7694 4.26177 11.7387 1.23108 8.00013 1.23108C4.26159 1.23108 1.2309 4.26177 1.2309 8.00031Z" fill="#2CCD65"/><path d="M4.66917 7.89742C4.43826 7.62873 4.03714 7.6015 3.77324 7.83661C3.50935 8.07172 3.48261 8.48013 3.71352 8.74882L5.93574 11.3347C6.18234 11.6216 6.61803 11.6301 6.87516 11.3529L12.272 5.53468C12.5128 5.27511 12.5013 4.86596 12.2463 4.62081C11.9914 4.37567 11.5896 4.38736 11.3488 4.64692L6.4315 9.94813L4.66917 7.89742Z" fill="#2CCD65"/></svg></div></label></div></div></div></div></div><div class="create-resume-form_main_btns"><button type="button" class="btn--purple create-course_check_block-assist-save">Сохранить занятие</button><button type="button" style="text-decoration: none;" class="link--purple create-course_check_block-assist-cancel" type="button">Отменить</button></div>'
  );
  $(".create-course_check_block-assist-add").removeClass("active");
  assistCancel();
  assistSave();
  assistDelete();
});

function assistDelete() {
  $(".create-course_check_block-assistents_block-item-delete").on(
    "click",
    function () {
      $(this).parent().parent().remove();
    }
  );
}
assistDelete();

$(".lesson-access-radio-label input").on("change", function () {
  $(".addprogram_anket-upload").attr("disabled", false);
  if ($(this).hasClass("lesson-access-radio-1")) {
    $(".lesson-access-radio-1-text").show();
    $(".lesson-access-radio-2-block").hide();
  } else if ($(this).hasClass("lesson-access-radio-2")) {
    $(".lesson-access-radio-1-text").hide();
    $(".lesson-access-radio-2-block").show();
  }
});

function createLink(str) {
  var ru = {
      а: "a",
      б: "b",
      в: "v",
      г: "g",
      д: "d",
      е: "e",
      ё: "e",
      ж: "j",
      з: "z",
      и: "i",
      к: "k",
      л: "l",
      м: "m",
      н: "n",
      о: "o",
      п: "p",
      р: "r",
      с: "s",
      т: "t",
      у: "u",
      ф: "f",
      х: "h",
      ц: "c",
      ч: "ch",
      ш: "sh",
      щ: "shch",
      ы: "y",
      э: "e",
      ю: "u",
      я: "ya",
    },
    n_str = [];
  str = str.replace(/[ъь]+/g, "").replace(/й/g, "i");
  for (var i = 0; i < str.length; ++i) {
    n_str.push(
      ru[str[i]] ||
        (ru[str[i].toLowerCase()] === undefined && str[i]) ||
        ru[str[i].toLowerCase()].replace(/^(.)/, function (match) {
          return match.toUpperCase();
        })
    );
  }
  return n_str.join("");
}
var textToLink = $(".textToLink"),
  linkToText = textToLink.next();
textToLink.on("input", function () {
  var j = createLink($(this).val());
  j = j.replace(/ /g, "-");
  j = j.replace(/,-/g, "-");
  j = j.replace(/\//g, "-");
  linkToText.val(j.toLowerCase());
});
