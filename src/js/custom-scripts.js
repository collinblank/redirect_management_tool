// EVENT LISTENERS

// Close success message
const successMsg = document.querySelector(".success-msg");
const successMsgXBtn = document.querySelector(".success-msg__x-btn");
successMsgXBtn.addEventListener("click", () => {
  // This may just need to refresh the page back to /servers/ without query parameters
  successMsg.classList.remove("active");
});

const addServerBtn = document.getElementById("add-server-btn");
addServerBtn.addEventListener("click", () => {
  showModal("add");
});

const editBtns = document.querySelectorAll(".edit-btn");
editBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    showModal("edit", e);
  });
});

const disableBtns = document.querySelectorAll(".disable-btn");
disableBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    showModal("disable", e);
  });
});

function showModal(actionType, e) {
  const mainContent = document.getElementById("content");
  const tableName = document.querySelector(".list-view").dataset.tableName;
  const itemId = e ? e.target.closest(".list-view__item").dataset.itemId : "";
  const params = `?action=${actionType}&table_name=${tableName}${
    itemId ? "" : `&item_id=${itemId}`
  }`;
  const modalPath =
    "/wp-content/themes/redirect-management-tool/parts/modals/modal.php";
  const url = modalPath + params;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const modal = xhr.responseText;
        console.log(modal);
        mainContent.insertAdjacentHTML("beforeend", modal);
      } else {
        console.error("Request failed with status: " + xhr.status);
      }
    }
  };

  xhr.send();
}
