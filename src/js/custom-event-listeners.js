const CustomEventListeners = {
  addInputEventListener(field, validateFn) {
    let blurredOnce = false;

    field.addEventListener("blur", () => {
      validateFn();
      blurredOnce = true;
    });

    field.addEventListener("input", () => {
      if (blurredOnce) {
        validateFn();
      }
    });
  },

  addSelectEventListener(field, validateFn) {
    function resetStyles(field) {
      if (field.value) {
        field.classList.add("has-value");
      } else {
        field.classList.remove("has-value");
      }
    }
    resetStyles(field);

    function selectEventHandler(field) {
      validateFn();
      resetStyles(field);
    }

    field.addEventListener("blur", () => {
      selectEventHandler(field);
    });

    field.addEventListener("change", () => {
      selectEventHandler(field);
    });
  },
};

export default CustomEventListeners;
