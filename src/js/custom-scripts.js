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

document.addEventListener("click", (e) => {
  if (e.target.classList.contains("cancel-btn")) {
    removeModal();
  }
});

function removeModal() {
  const modal = document.querySelector(".modal-overlay");
  modal.remove();
}

function showModal(action, e) {
  const mainContent = document.getElementById("content");
  const tableName = document.querySelector(".list-view").dataset.tableName;
  const itemId = e ? e.target.closest(".list-view__item").dataset.itemId : "";
  const params = `?action=${action}&table_name=${tableName}${
    itemId ? `&item_id=${itemId}` : ""
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
        mainContent.insertAdjacentHTML("beforeend", modal);
        if (action === "add" || action === "edit") {
          // init form validation logic
          initFormValidation(tableName);
        }
      } else {
        console.error("Request failed with status: " + xhr.status);
      }
    }
  };

  xhr.send();
}

// FORM VALIDATION

function initFormValidation(tableName) {
  if (tableName === "servers") {
    initServerFormValidation();
  }

  function initServerFormValidation() {
    const serverNameInput = document.getElementById("server-name");
    const serverDomainInput = document.getElementById("server-domain");

    function checkServerName() {
      const msg = serverNameInput.nextElementSibling;

      if (!serverNameInput.validity.valid) {
        if (serverNameInput.validity.valueMissing) {
          msg.textContent = "Please enter a server name.";
        } else {
          msg.textContent =
            "Please enter between 4 and 50 letters and spaces only (no spaces at either end!).";
        }
        serverNameInput.classList.remove("valid");
        serverNameInput.classList.add("invalid");
        msg.classList.remove("success", "active");
        msg.classList.add("error", "active");
      } else {
        serverNameInput.classList.remove("invalid");
        serverNameInput.classList.add("valid");
        msg.textContent = "Great!";
        msg.classList.remove("error", "active");
        msg.classList.add("success", "active");
      }
    }

    // EVENT LISTENER
    serverNameInput.addEventListener("click", () => {
      serverNameInput.addEventListener("blur", () => {
        checkServerName();
        serverNameInput.addEventListener("input", checkServerName);
      });
    });

    function checkServerDomain() {
      const msg = serverDomainInput.nextElementSibling;

      if (!serverDomainInput.validity.valid) {
        if (serverDomainInput.validity.valueMissing) {
          msg.textContent = "Please enter a server name.";
        } else {
          msg.textContent = "Please enter a valid URL.";
        }
        serverDomainInput.classList.remove("valid");
        serverDomainInput.classList.add("invalid");
        msg.classList.remove("success", "active");
        msg.classList.add("error", "active");
      } else {
        serverDomainInput.classList.remove("invalid");
        serverDomainInput.classList.add("valid");
        msg.textContent = "Great!";
        msg.classList.remove("error", "active");
        msg.classList.add("success", "active");
      }
    }

    serverDomainInput.addEventListener("click", () => {
      serverDomainInput.addEventListener("blur", () => {
        checkServerName();
        serverDomainInput.addEventListener("input", checkServerDomain);
      });
    });
  }
}
