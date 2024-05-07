const modal = document.querySelector(".modal");
const toggleModalBtns = document.querySelectorAll(".toggle-modal-btn");
console.log("is this getting called?");

toggleModalBtns.forEach((btn) => {
  btn.addEventListener("click", function () {
    toggleModal(modal);
  });
});

function toggleModal(modal) {
  if (modal.classList.contains("active")) {
    modal.classList.remove("active");
  } else {
    modal.classList.add("active");
  }
}
