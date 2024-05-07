const modal = document.querySelector(".modal");
const toggleModalBtn = document.querySelector(".toggle-modal-btn");
console.log("script called!");

toggleModalBtn.addEventListener("click", function () {
  toggleModal(modal);
  console.log("button click works!");
});

function toggleModal(modal) {
  if (modal.classList.contains("active")) {
    modal.classList.remove("active");
  } else {
    modal.classList.add("active");
  }
}
