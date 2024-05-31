// Event listeners

// Close success message
const successMsg = document.querySelector(".success-msg");
const successMsgXBtn = document.querySelector(".success-msg__x-btn");
successMsgXBtn.addEventListener("click", () => {
  // This may just need to refresh the page back to /servers/ without query parameters
  successMsg.classList.remove("active");
});

const addServerBtn = document.getElementById("add-server-btn");
addServerBtn.addEventListener("click", showAddServerModal);

const disableBtns = document.querySelectorAll(".disable-btn");
disableBtns.forEach((btn) => {
  btn.addEventListener("click", handleDisableBtnClick);
});

const cancelBtns = document.querySelectorAll(".cancel-btn");
cancelBtns.forEach((btn) => {
  btn.addEventListener("click", removeModal);
});

// --------

// Just for servers right now
function handleDisableBtnClick(e) {
  const itemId = e.target.closest(".list-view__item").dataset.itemId;
  const tableName = "Servers";
  const params = `?table_name=${tableName}&item_id=${itemId}`;
  const filePath = "/wp-content/themes/redirect-management-tool/get-item.php";
  const url = filePath + params;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const item = JSON.parse(xhr.responseText);
        console.log(item);
        showDisableServerModal(item);
      } else {
        console.error("Request failed with status: " + xhr.status);
        console.error("Response text: " + xhr.responseText);
      }
    }
  };

  xhr.send();
}

// just for servers right now
function showDisableServerModal(item) {
  const params = `?server_name=${item.Name}&server_domain=${item.Domain}`;
  const filePath = "parts/modals/disable-server-modal.php";
  showModal(filePath, params);
}

function showAddServerModal() {
  const filePath = "parts/modals/add-server-modal.php";
  showModal(filePath);
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
        mainContent.insertAdjacentHTML("beforeend", modal);
      } else {
        console.error("Request failed with status: " + xhr.status);
      }
    }
  };

  xhr.send();
}

function removeModal() {
  const modal = document.querySelector(".modal");
  modal.remove();
}
