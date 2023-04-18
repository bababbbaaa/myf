function changeStep(step) {
  $(".step-" + step).addClass("done");
  $(".write-" + step++).attr("hidden", "");
  $(".step-" + step)
    .removeAttr("disabled")
    .removeClass("done");
  $(".write-" + step).removeAttr("hidden");
}

$(".step").on("click", function () {
  let step = $(this).attr("data-step");
  if ($(this).attr("disabled")) {
    return false;
  } else {
    $(".write").attr("hidden", "");
    $(".write-" + step).removeAttr("hidden");
    $(".step").each(function () {
      if (!$(this).attr("disabled")) $(this).addClass("done");
    });
    $(".step-" + step).removeClass("done");
  }
});

$(".nextStep").on("click", function () {
  let step = $(this).attr("data-step");
  changeStep(step);
});

var object = localStorage.getItem("course")
  ? JSON.parse(localStorage.getItem("course"))
  : {};

$("input, textarea, select").on("change", function () {
  object[this.name] = $(this).val();
  console.log(object);
  localStorage.setItem("course", JSON.stringify(object));
});

$(".courseName").on("input", function () {
  var j = createLink($(this).val());
  j = j.replace(/ /g, "-");
  j = j.replace(/,-/g, "-");
  j = j.replace(/\\/g, "-");
  j = j.replace(/\//g, "-");
  $(".courseLink").val(j.toLowerCase());
});

$(".moduleTitle").on("input", function () {
  var j = createLink($(this).val());
  j = j.replace(/ /g, "-");
  j = j.replace(/,-/g, "-");
  j = j.replace(/\\/g, "-");
  j = j.replace(/\//g, "-");
  $(".moduleLink").val(j.toLowerCase());
});

$(window).ready(function () {
  for (const key in object) {
    $('[name="' + key + '"]').val(object[key]);
  }
});
