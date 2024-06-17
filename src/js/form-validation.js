export function initFormValidation(tableName) {
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

export function initDisableItemFormValidation() {
  const form = document.getElementById("disable-item__form");
  const checkbox = form.querySelector('input[type="checkbox"]');
  const disableBtn = form.querySelector('input[type="submit"]');

  checkbox.addEventListener("change", () => {
    disableBtn.disabled = !checkbox.checked;
  });
}
