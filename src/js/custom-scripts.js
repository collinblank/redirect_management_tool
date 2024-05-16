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

const disableBtns = document.querySelectorAll(".disable-btn");
disableBtns.forEach((btn) => {
  btn.addEventListener("click", showDisableModal);
});

// Just for servers right now
function showDisableModal(e) {
  const itemId = e.target.closest(".list-view__item").dataset.itemId;
  const params = `item_id=${itemId}`;
  console.log(itemId);

  const xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "/wp-content/themes/redirect-management-tool/get-server.php",
    true
  );
  xhr.setRequestHeader("Content-type", "application/json");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      console.log(data);
      const disableModal = document.querySelector(".disable-modal");
      toggleModal(disableModal);
    } else {
      console.error("Error:", xhr.statusText);
    }
  };

  xhr.send(params);
}

// Notes:
// For some reason the open url path isn't being found. This is what the site says leads to a 404: https://redirectmanager.classicaltesting.net/src/requests/get-server.php
// might be missing the redirect_management_tool part
