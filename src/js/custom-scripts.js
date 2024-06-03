// EVENT LISTENERS

// Close success message
const successMsg = document.querySelector(".success-msg");
const successMsgXBtn = document.querySelector(".success-msg__x-btn");
successMsgXBtn.addEventListener("click", () => {
  // This may just need to refresh the page back to /servers/ without query parameters
  successMsg.classList.remove("active");
});

const addServerBtn = document.getElementById("add-server-btn");
addServerBtn.addEventListener("click", handleAddItemBtnClick);

const disableBtns = document.querySelectorAll(".disable-btn");
disableBtns.forEach((btn) => {
  btn.addEventListener("click", handleDisableItemBtnClick);
});

const editBtns = document.querySelectorAll(".edit-btn");
editBtns.forEach((btn) => {
  btn.addEventListener("click", handleEditItemBtnClick);
});

// this doesn't work cause the modal appears after document and script are loaded
const cancelBtns = document.querySelectorAll(".cancel-btn");
cancelBtns.forEach((btn) => {
  btn.addEventListener("click", removeModal);
});

// --------

// EVENT HANDLERS

function handleAddItemBtnClick() {
  const tableName = document.querySelector(".list-view").dataset.tableName;
  const filePath = "parts/modals/form-modal.php";
  const params = `?table_name=${tableName}`;
  showModal(filePath, params);
}

function handleEditItemBtnClick(e) {
  const tableName = e.target.closest(".list-view").dataset.tableName;
  const itemId = e.target.closest(".list-view__item").dataset.itemId;
  const filePath = "parts/modals/form-modal.php";
  const params = `?table_name=${tableName}&item_id=${itemId}`;
  showModal(filePath, params);
}

function handleDisableItemBtnClick(e) {
  const tableName = e.target.closest(".list-view").dataset.tableName;
  const itemId = e.target.closest(".list-view__item").dataset.itemId;
  const filePath = "parts/modals/disable-modal.php";
  const params = `?table_name=${tableName}&item_id=${itemId}`;
  showModal(filePath, params);
}

// SHOW/REMOVE MODALS
function removeModal() {
  const modal = document.querySelector(".modal");
  modal.remove();
}

function showModal(modalFilePath, params = "") {
  const mainContent = document.getElementById("content");
  const rootDir = "/wp-content/themes/redirect-management-tool/";
  const url = rootDir + modalFilePath + params;
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
