// Open/close modals
const modal = document.querySelector(".modal");
const toggleModalBtns = document.querySelectorAll(".toggle-modal-btn");
console.log("script called!");

toggleModalBtns.forEach((btn) => {
  btn.addEventListener("click", function () {
    toggleModal(modal);
    console.log("button click works!");
  });
});

function toggleModal(modal) {
  if (modal.classList.contains("active")) {
    modal.classList.remove("active");
  } else {
    modal.classList.add("active");
  }
}

// Close success message
const successMsg = document.querySelector(".success-msg");
const successMsgXBtn = document.querySelector(".success-msg__x-btn");
successMsgXBtn.addEventListener("click", () => {
  // This may just need to refresh the page back to /servers/ without query parameters
  successMsg.classList.remove("active");
});
