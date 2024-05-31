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
  btn.addEventListener("click", handleDisableBtnClick);
});

// Just for servers right now
function handleDisableBtnClick(e) {
  const itemId = e.target.closest(".list-view__item").dataset.itemId;
  const tableName = "Servers";
  const params = `?table_name=${tableName}&item_id${itemId}`;
  const filePath = "/wp-content/themes/redirect-management-tool/get-item.php";
  const url = filePath + params;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      console.log("http request complete");
      if (xhr.status === 200) {
        const item = JSON.parse(xhr.responseText);
        console.log(item);
        showDisableModal(item);
      } else {
        // console.error("Error: " + xhr.status);
        console.error("Request failed with status: " + xhr.status);
        // console.error("Status text: " + xhr.statusText);
        // console.error("Response text: " + xhr.responseText);
        // console.error("Ready state: " + xhr.readyState);
        // console.error("Response headers: " + xhr.getAllResponseHeaders());
      }
    }
  };

  xhr.send();
}

// just for servers right now
function showDisableModal(item) {
  const mainContent = document.getElementById("content");
  const params = `?server_name=${item.Name}&server_domain=${item.Domain}`;
  const filePath =
    "/wp-content/themes/redirect-management-tool/parts/modals/disable-server-modal.php";
  const url = filePath + params;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log("http request ok");
        const disableModal = xhr.responseText;
        console.log(disableModal);
        mainContent.appendChild(disableModal);
      } else {
        console.error("Request failed with status: " + xhr.status);
      }
    }
  };

  xhr.send();

  // const disableModal = `
  //   <div class="modal disable-modal active">
  //       <div class="disable-modal__content-container">
  //         <h3>Are you sure you want to delete this server?</h3>
  //         <p>This action cannot be undone.</p>
  //         <div>
  //             <h4>${item.Name}</h4>
  //             <p>${item.Domain}</p>
  //         </div>
  //         <div class="btns-container">
  //             <button class="default-btn toggle-modal-btn">Cancel</button>
  //             <button>Delete</button>
  //         </div>
  //     </div>
  //   </div>
  // `;
  // mainContent.appendChild(disableModal);
  // const disableModal = document.querySelector(".disable-modal");
  // toggleModal(disableModal);
}
