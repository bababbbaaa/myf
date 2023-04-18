document.querySelectorAll(".accordion").forEach((el) => {
  el.addEventListener("click", () => {
    el.classList.toggle("active")
  })
})
