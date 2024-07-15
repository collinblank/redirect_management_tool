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
  switch (tableName) {
    case "servers":
      initServerFormValidation();
      break;
    case "websites":
      initWebsiteFormValidation();
      break;
  }
}

function initInputEvents(input, handler) {
  // const submitBtn = form.querySelector('input[type="submit"]');
  let blurredOnce = false;

  // input.addEventListener("focus", () => {
  //   // submitBtn.disabled = !allInputsValid();
  // });

  input.addEventListener("blur", () => {
    // submitBtn.disabled = !allInputsValid();
    handler(input);
    blurredOnce = true;
  });

  input.addEventListener("input", () => {
    // submitBtn.disabled = !allInputsValid();
    if (blurredOnce) {
      handler(input);
    }
  });
}

function initSelectEvents(select, handler) {
  select.addEventListener("blur", handler);
  select.addEventListener("change", handler);
}

function allInputsValid() {
  const inputs = form.querySelectorAll(".form__input-item input");
  return Array.from(inputs).every((input) => input.validity.valid);
}

function initDisableItemFormValidation() {
  const form = document.getElementById("disable-item__form");
  const checkbox = form.querySelector('input[type="checkbox"]');
  const disableBtn = form.querySelector('input[type="submit"]');

  checkbox.addEventListener("change", () => {
    disableBtn.disabled = !checkbox.checked;
  });
}

function initServerFormValidation() {
  const name = document.getElementById("server-name");
  const domain = document.getElementById("server-domain");

  initInputEvents(name, handleNameEvents);
  initInputEvents(domain, handleDomainEvents);

  function handleNameEvents() {
    Validator.checkName(name);
    toggleSubmitBtn();
  }

  function handleDomainEvents() {
    Validator.checkDomain(domain);
    toggleSubmitBtn();
  }

  function toggleSubmitBtn() {
    submitBtn.disabled = !Validator.checkAllFields([name, domain]);
  }
}

function initWebsiteFormValidation() {
  const submitBtn = document.getElementById("website-form-submit-btn");
  const name = document.getElementById("website-name");
  const domain = document.getElementById("website-domain");
  const server = document.getElementById("website-server");

  setSelectStyles();
  initInputEvents(name, handleNameEvents);
  initInputEvents(domain, handleDomainEvents);
  initSelectEvents(server, handleServerEvents);

  function handleNameEvents() {
    Validator.checkName(name);
    toggleSubmitBtn();
  }

  function handleDomainEvents() {
    Validator.checkDomain(domain);
    toggleSubmitBtn();
  }

  function handleServerEvents() {
    Validator.checkSelect(server);
    toggleSandbox();
    toggleSubmitBtn();
  }

  function toggleSandbox() {
    const sandboxField = document.getElementById("website-sandbox-list-item");
    const isProdServer = server.value !== "3";

    if (server.validity.valid && isProdServer) {
      sandboxField.classList.remove("hidden");
    } else {
      sandboxField.classList.add("hidden");
    }
  }

  function toggleSubmitBtn() {
    submitBtn.disabled = !Validator.checkAllFields([name, domain, server]);
  }

  function setSelectStyles() {
    const selects = document.querySelectorAll(".form__input-item select");
    selects.forEach((select) => {
      if (select.value) {
        select.classList.add("active");
      }
      select.addEventListener("change", () => {
        if (select.value) {
          select.classList.add("active");
        } else {
          select.classList.remove("active");
        }
      });
    });
  }
}

class Validator {
  static checkName(name) {
    // const pattern = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
    // return pattern.test(name) && name.length >= min && name.length <= max;
    if (!name.validity.valid) {
      if (name.validity.valueMissing) {
        this._setErrorMsg(name, "Please enter a value.");
      } else {
        this._setErrorMsg(
          name,
          "Please enter between 4 and 50 letters and spaces only."
        );
      }
    } else {
      this._setSuccessMsg(name, "Awesome!");
    }
  }

  static checkDomain(domain) {
    // const pattern = /^https?:\/\/.*$/;
    // return pattern.test(domain) && domain.length >= min && domain.length <= max;

    if (!domain.validity.valid) {
      if (domain.validity.valueMissing) {
        this._setErrorMsg(domain, "Please enter a value.");
      } else {
        this._setErrorMsg(
          domain,
          "Please enter a valid URL (including http(s)://)."
        );
      }
    } else {
      this._setSuccessMsg(domain, "Looking good!");
    }
  }

  static checkSelect(select) {
    if (select.validity.valueMissing) {
      this._setErrorMsg(select, "Please select a value.");
    } else {
      this._setSuccessMsg(select, "Great!");
    }
  }

  static checkAllFields(fields = []) {
    return fields.every((field) => field.validity.valid);
  }

  static _setErrorMsg(input, errorMsg) {
    const msg = input.nextElementSibling;
    msg.textContent = errorMsg;

    input.classList.remove("valid");
    input.classList.add("invalid");
    msg.classList.remove("success", "active");
    msg.classList.add("error", "active");
  }

  static _setSuccessMsg(input, successMsg) {
    const msg = input.nextElementSibling;
    msg.textContent = successMsg;

    input.classList.remove("invalid");
    input.classList.add("valid");
    msg.classList.remove("error", "active");
    msg.classList.add("success", "active");
  }
}

/* Organization

Class Validator
 - All input check methods (domain, server, name, etc.)


Individual Init fns for forms
 - 



 */
