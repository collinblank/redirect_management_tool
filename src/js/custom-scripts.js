// Event listeners

// Close success message
const successMsg = document.querySelector(".success-msg");
const successMsgXBtn = document.querySelector(".success-msg__x-btn");
successMsgXBtn.addEventListener("click", () => {
  // This may just need to refresh the page back to /servers/ without query parameters
  successMsg.classList.remove("active");
});

const addServerBtn = document.getElementById("add-server-btn");
addServerBtn.addEventListener("click", () => {
  showAddModal("server");
});

// Just for servers right now
const disableBtns = document.querySelectorAll(".disable-btn");
disableBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    handleDisableBtnClick(e, "Servers", showDisableServerModal);
  });
});

const cancelBtns = document.querySelectorAll(".cancel-btn");
cancelBtns.forEach((btn) => {
  btn.addEventListener("click", removeModal);
});

// --------

function handleDisableBtnClick(e, tableName, showDisableModalFunc) {
  const itemId = e.target.closest(".list-view__item").dataset.itemId;
  const filePath = "/wp-content/themes/redirect-management-tool/get-item.php";
  const params = `?table_name=${tableName}&item_id=${itemId}`;
  const url = filePath + params;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const item = JSON.parse(xhr.responseText);
        console.log(item);
        showDisableModalFunc(item);
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
  const filePath = "parts/modals/disable-server-modal.php";
  const params = `?server_name=${item.Name}&server_domain=${item.Domain}`;
  showModal(filePath, params);
}

// something like this for a general function
// function showDisableModal(item) {
//   const filePath;
//   const params = `?item_name=${item.Name}&item_info=${item.Domain ? item.Domain : item.redirectFlagRule}`;
//   // the above params need an item_type somehow. For determing whether it's a website, server, etc.
//   showModal(filePath, params);
// }

// each add function needs to be specific because each form is different. Or I can pass the forms in via
// function showAddServerModal() {
//   const filePath = "parts/modals/add-server-modal.php";
//   showModal(filePath);
// }

// attempt at generic function for add modals
function showAddModal(itemType) {
  const filePath = "parts/modals/add-modal.php";
  const params = `?item_type=${itemType}`;
  showModal(filePath, params);
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

function removeModal() {
  const modal = document.querySelector(".modal");
  modal.remove();
}
