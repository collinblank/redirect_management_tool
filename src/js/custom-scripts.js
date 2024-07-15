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

// const form = document.querySelector(".modal-form");

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

function initInputEvents(input, validateFunc) {
  // const submitBtn = form.querySelector('input[type="submit"]');
  let blurredOnce = false;

  // input.addEventListener("focus", () => {
  //   // submitBtn.disabled = !allInputsValid();
  // });

  input.addEventListener("blur", () => {
    // submitBtn.disabled = !allInputsValid();
    validateFunc();
    blurredOnce = true;
  });

  input.addEventListener("input", () => {
    // submitBtn.disabled = !allInputsValid();
    if (blurredOnce) {
      validateFunc();
    }
  });
}

function initSelectEvents(select, validateFunc) {
  // const submitBtn = form.querySelector('input[type="submit"]');
  let blurredOnce = false;

  // select.addEventListener("focus", () => {
  //   // submitBtn.disabled = !allInputsValid();
  // });

  select.addEventListener("blur", () => {
    // submitBtn.disabled = !allInputsValid();
    validateFunc();
    blurredOnce = true;
  });

  select.addEventListener("change", () => {
    // submitBtn.disabled = !allInputsValid();
    if (blurredOnce) {
      validateFunc();
    }
  });
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
  const nameInput = document.getElementById("server-name");
  const domainInput = document.getElementById("server-domain");
  // EVENT LISTENERS
  initInputEvents(nameInput, checkServerName);
  initInputEvents(domainInput, checkServerDomain);

  function checkServerName() {
    const responseMsgs = {
      error: "Please enter between 4 and 50 letters and spaces only.",
      success: "Awesome!",
    };
    checkServerInput(nameInput, responseMsgs);
  }

  function checkServerDomain() {
    const responseMsgs = {
      error: "Please enter a valid URL (including http(s)://).",
      success: "Great!",
    };
    checkServerInput(domainInput, responseMsgs);
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

function initWebsiteFormValidation() {
  const name = document.getElementById("website-name");
  const domain = document.getElementById("website-domain");
  const server = document.getElementById("website-server");
  const sandbox = document.getElementById("website-sandbox");

  setSelectStyles();

  // EVENT LISTENERS
  initInputEvents(name, validateName);
  initInputEvents(domain, validateDomain);
  initSelectEvents(server, validateServer);

  function validateName() {
    if (name.validity.valueMissing) {
      setErrorMsg(name, "Please enter a value.");
    } else if (!Validator.checkName(name.value)) {
      setErrorMsg(
        name,
        "Please enter between 4 and 50 letters and spaces only."
      );
    } else {
      setSuccessMsg(name, "Awesome!");
    }
  }

  function validateDomain() {
    if (domain.validity.valueMissing) {
      setErrorMsg(domain, "Please enter a value.");
    } else if (!Validator.checkDomain(domain.value)) {
      setErrorMsg(domain, "Please enter a valid URL (including http(s)://).");
    } else {
      setSuccessMsg(domain, "Great!");
    }
  }

  function validateServer() {
    if (server.validity.valueMissing) {
      setErrorMsg(server, "Please select a value.");
      toggleSandbox();
    } else {
      setSuccessMsg(server, "Looking good!");
      toggleSandbox();
    }
  }

  // don't need a validateSandbox because the field isn't required

  function toggleSandbox() {
    const sandboxField = document.getElementById("website-sandbox-list-item");
    const isProdServer = server.value === "1" || server.value === "5";
    console.log(server.value);
    console.log("isProdServer: " + isProdServer);
    if (server.validity.valid && isProdServer) {
      sandboxField.classList.remove("hidden");
      console.log("Yes: sandbox select shown.");
    } else {
      sandboxField.classList.add("hidden");
      console.log("No: sandbox select not shown.");
    }
  }
}

function setErrorMsg(input, errorMsg) {
  const msg = input.nextElementSibling;
  msg.textContent = errorMsg;

  input.classList.remove("valid");
  input.classList.add("invalid");
  msg.classList.remove("success", "active");
  msg.classList.add("error", "active");
}

function setSuccessMsg(input, successMsg) {
  const msg = input.nextElementSibling;
  msg.textContent = successMsg;

  input.classList.remove("invalid");
  input.classList.add("valid");
  msg.classList.remove("error", "active");
  msg.classList.add("success", "active");
}

class Validator {
  static checkName(name, min = 4, max = 50) {
    const pattern = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
    return pattern.test(name) && name.length > min && name.length < max;
  }

  static checkDomain(domain, min = 6, max = 100) {
    const pattern = /^https?:\/\/.*$/;
    return pattern.test(domain) && domain.length > min && domain.length < max;
  }
}

/* Organization

Class Validator
 - All input check methods (domain, server, name, etc.)


Individual Init fns for forms
 - 



 */
