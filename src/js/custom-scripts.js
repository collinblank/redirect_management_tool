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

  const form = document.querySelector(".modal-form");
  const submitBtn = form.querySelector('input[type="submit"]');
  const inputs = form.querySelectorAll(".form__input-item input");

  function initServerFormValidation() {
    const serverNameInput = document.getElementById("server-name");
    const serverDomainInput = document.getElementById("server-domain");
    // EVENT LISTENERS
    initInputEvents(serverNameInput, checkServerName);
    initInputEvents(serverDomainInput, checkServerDomain);

    function checkServerName() {
      const pattern = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
      checkServerInput(serverNameInput, pattern, {
        error: "Please enter between 4 and 50 letters and spaces only.",
        success: "Awesome!",
      });
    }

    function checkServerDomain() {
      const pattern = /^(https?:\/\/)(www\.)?[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      checkServerInput(serverDomainInput, pattern, {
        error: "Please enter a valid URL (including http(s)://).",
        success: "Great!",
      });
    }

    function checkServerInput(input, pattern, responseMsgs) {
      const msg = input.nextElementSibling;

      if (!input.validity.valid) {
        if (input.validity.valueMissing) {
          msg.textContent = "Please enter a value.";
        } else if (!pattern.test(input.value)) {
          msg.textContent = "Correct your pattern!";
        } else {
          msg.textContent = responseMsgs.error;
        }
        input.classList.remove("valid");
        input.classList.add("invalid");
        msg.classList.remove("success", "active");
        msg.classList.add("error", "active");
      } else {
        msg.textContent = responseMsgs.success;
        input.classList.remove("invalid");
        input.classList.add("valid");
        msg.classList.remove("error", "active");
        msg.classList.add("success", "active");
      }
    }
  }

  function initInputEvents(input, checkInputFunc) {
    let blurredOnce = false;

    input.addEventListener("focus", () => {
      submitBtn.disabled = !allInputsValid();
    });

    input.addEventListener("blur", () => {
      submitBtn.disabled = !allInputsValid();
      checkInputFunc();
      blurredOnce = true;
    });

    input.addEventListener("input", () => {
      submitBtn.disabled = !allInputsValid();
      if (blurredOnce) {
        checkInputFunc();
      }
    });
  }

  function allInputsValid() {
    return Array.from(inputs).every((input) => input.validity.valid);
  }
}
