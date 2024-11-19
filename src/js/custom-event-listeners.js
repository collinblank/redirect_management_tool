const CustomEventListeners = {
  addInputEventListener(field, handler) {
    let blurredOnce = false;

    field.addEventListener("blur", () => {
      handler();
      blurredOnce = true;
    });

    field.addEventListener("input", () => {
      if (blurredOnce) {
        handler();
      }
    });
  },

  addSelectEventListener(field, handler) {
    function resetStyles(field) {
      if (field.value) {
        field.classList.add("has-value");
      } else {
        field.classList.remove("has-value");
      }
    }
    resetStyles(field);

    function selectEventHandler(field) {
      handler();
      resetStyles(field);
    }

    field.addEventListener("blur", () => {
      selectEventHandler(field);
    });

    field.addEventListener("change", () => {
      selectEventHandler(field);
    });
  },

  addDropAreaEventListener(field, handler) {
    const dropArea = field.previousElementSibling.classList.contains(
      "upload-drop-area"
    )
      ? field.previousElementSibling
      : null;
    // util to prevent any default behaviors
    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    dropArea.addEventListener("dragover", (e) => {
      preventDefaults(e);
      dropArea.classList.add("drag-over");
    });
    dropArea.addEventListener("dragenter", preventDefaults);
    dropArea.addEventListener("dragleave", (e) => {
      preventDefaults(e);
      dropArea.classList.remove("drag-over");
    });

    dropArea.addEventListener("drop", (e) => {
      dropArea.classList.remove('drag-over');
      handler(e)
    });
  },
};

export default CustomEventListeners;
