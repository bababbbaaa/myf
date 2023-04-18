const header = document.querySelector(".header");

document.addEventListener("scroll", () => {
  if (pageYOffset >= 50) {
    header.classList.add("header__active");
  } else {
    header.classList.remove("header__active");
  }
});
