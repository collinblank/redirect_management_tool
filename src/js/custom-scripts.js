// EVENT LISTENERS
const addItemBtn = document.querySelector(".add-item-btn");
addItemBtn.addEventListener("click", (e) => {
  showModal("add");
});

const editItemBtns = document.querySelectorAll(".edit-item-btn");
editItemBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    showModal("edit", e);
  });
});

const disableItemBtns = document.querySelectorAll(".disable-item-btn");
disableItemBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    showModal("disable", e);
  });
});

// random events for elements loaded after initial page load
// Just for now...
document.addEventListener("click", (e) => {
  // probably should be added when the modal appears
  if (e.target.id === "modal-cancel-btn") {
    removeModal();
  }
  if (e.target.classList.contains("notice-banner__x-btn")) {
    console.log("btn clicked");
    const noticeBanner = document.querySelector(".notice-banner");
    console.log(noticeBanner);
    noticeBanner.remove();
  }
});

// FUNCTIONS
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
    "/wp-content/themes/redirect-management-tool/parts/modal.php";
  const url = modalPath + params;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const modal = xhr.responseText;
        mainContent.insertAdjacentHTML("beforeend", modal);

        // init form validation logic
        if (action === "add" || action === "edit") {
          initFormValidation(tableName);
        } else if (action === "disable") {
          initDisableItemFormValidation();
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
      const responseMsgs = {
        error: "Please enter between 4 and 50 letters and spaces only.",
        success: "Awesome!",
      };
      checkServerInput(serverNameInput, responseMsgs);
    }

    function checkServerDomain() {
      const responseMsgs = {
        error: "Please enter a valid URL (including http(s)://).",
        success: "Great!",
      };
      checkServerInput(serverDomainInput, responseMsgs);
    }

    function checkServerInput(input, responseMsgs) {
      const msg = input.nextElementSibling;
      // const patternMismatch = !pattern.test(input.value);

      if (!input.validity.valid) {
        if (input.validity.valueMissing) {
          msg.textContent = "Please enter a value.";
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

  // function initWebsiteFormValidation() {

  // }

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

function initDisableItemFormValidation() {
  const form = document.getElementById("disable-item__form");
  const checkbox = form.querySelector('input[type="checkbox"]');
  const disableBtn = form.querySelector('input[type="submit"]');

  checkbox.addEventListener("change", () => {
    disableBtn.disabled = !checkbox.checked;
  });
}
