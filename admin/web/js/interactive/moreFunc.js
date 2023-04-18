$(".show_author-create").on("click", function () {
  $(".author__select").fadeOut(300, function () {
    $(".author__block").fadeIn(300);
  });
});

$(".show_author-add").on("click", function () {
  $(".author__block").fadeOut(300, function () {
    $(".author__select").fadeIn(300);
  });
});

$(".addCategory").on("click", function () {
  $(".choose_category").fadeOut(300, function () {
    $(".addCategory_block").fadeIn(300);
  });
});

$(".chooseCategory").on("click", function () {
  $(".addCategory_block").fadeOut(300, function () {
    $(".choose_category").fadeIn(300);
  });
});

$(".addTeacher").on("click", function () {
  $(".teacher__choose").fadeOut(300, function () {
    $(".teacher__create").fadeIn(300);
  });
});

$(".teacherChoose").on("click", function () {
  $(".teacher__create").fadeOut(300, function () {
    $(".teacher__choose").fadeIn(300);
  });
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
