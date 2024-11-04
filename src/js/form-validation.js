import CustomEventListeners from "./custom-event-listeners.js";

export class FormValidationController {
  constructor(formSelector) {
    this.form = document.querySelector(formSelector);
    this.submitBtn = this.form.querySelector('input[type="submit"]');
    this.fields = Array.from(
      this.form.querySelectorAll(
        "input[type='text'], input[type='url'], input[type='checkbox'], textarea, select"
      )
    );
    this.validationRules = {
      name: {
        validate: (value) => /^[a-zA-Z\s]{4,50}$/.test(value),
        success: "That's an awesome name!",
        error: "Please enter between 4 and 50 letters and spaces only.",
      },
      domain: {
        // add length to regex pattern
        validate: (value) => /^https?:\/\/.+/.test(value),
        success: "Great choice in a domain.",
        error: "Please enter a valid URL (including http(s)://).",
      },
      textarea: {
        validate: (value) => value.length > 0,
        success: "An indescribably descriptive description.",
        error: "Please enter a value",
      },
    };

    this.initEvents();
  }

  showFeedbackMessage(field, type, message = "") {
    const prevSuccessMessage =
      field.classList.contains("valid") &&
      field.nextElementSibling.classList.contains("form-feedback-msg")
        ? field.nextElementSibling.textContent
        : null;
    this.clearFeedbackMessage(field);

    const defaultSuccessMessages = [
      "Nice!",
      "Awesome!",
      "Fantastic!",
      "Looking good!",
      "Thanks!",
      "Great!",
    ];

    const feedbackMessageEl = document.createElement("p");
    feedbackMessageEl.classList.add(
      "form-feedback-msg",
      type === "success" ? "valid" : "invalid"
    );

    if (type === "success" && prevSuccessMessage) {
      feedbackMessageEl.textContent = prevSuccessMessage;
    } else if (type === "success" && !message) {
      feedbackMessageEl.textContent =
        defaultSuccessMessages[
          Math.floor(Math.random() * defaultSuccessMessages.length)
        ];
    } else {
      feedbackMessageEl.textContent = message;
    }

    field.classList.toggle("valid", type === "success");
    field.classList.toggle("invalid", type === "error");
    field.after(feedbackMessageEl);
  }

  clearFeedbackMessage(field) {
    const feedbackMessageEl =
      field.parentElement.querySelector(".form-feedback-msg");

    if (feedbackMessageEl) feedbackMessageEl.remove();
    field.classList.remove("valid", "invalid");
  }

  validateSubmitBtn() {
    const formIsValid =
      this.form.checkValidity() &&
      this.fields.every((field) => this.validateField(field));
    this.submitBtn.disabled = !formIsValid;
  }

  validateField(field) {
    const fieldType = field.dataset.fieldType;
    const rule = this.validationRules[fieldType];
    const value = field.value.trim();

    // special case for checkboxes
    if (fieldType === "checkbox") {
      return true;
    }

    // check html validation first
    if (!field.validity.valid) {
      if (field.validity.valueMissing) {
        this.showFeedbackMessage(field, "error", "Please enter a value.");
      } else if (rule) {
        this.showFeedbackMessage(field, "error", rule.error);
      } else {
        this.showFeedbackMessage(
          field,
          "error",
          `Invalid input type. Enter a valid ${field.type}.`
        );
      }
      return false;
    }

    // case for optional fields
    if (!value) {
      this.clearFeedbackMessage(field);
      return true;
    }

    // for required fields with custom validation rules
    if (rule) {
      if (rule.validate(value)) {
        this.showFeedbackMessage(field, "success", rule.success);
        return true;
      } else {
        this.showFeedbackMessage(field, "error", rule.error);
        return false;
      }
    }

    this.showFeedbackMessage(field, "success");
    return true;
  }

  handleServerSelect(field) {
    const sandboxFieldEl = document.getElementById("website-sandbox-list-item");
    // show when production server is selected (classicaltesting.net server id is 3)
    sandboxFieldEl.classList.toggle(
      "active",
      field.value && field.value !== "3"
    );
  }

  initEvents() {
    this.fields.forEach((field) => {
      const fieldType = field.dataset.fieldType;

      if (fieldType === "checkbox") {
        field.addEventListener("change", () => {
          this.validateField(field);
          this.validateSubmitBtn();
        });
      } else if (fieldType === "select") {
        CustomEventListeners.addSelectEventListener(field, () => {
          this.validateField(field);
          this.validateSubmitBtn();
          if (field.id === "website-server") {
            this.handleServerSelect(field);
          }
        });
      } else {
        // input or textbox
        CustomEventListeners.addInputEventListener(field, () => {
          this.validateField(field);
          this.validateSubmitBtn();
        });
      }
    });
  }
}
