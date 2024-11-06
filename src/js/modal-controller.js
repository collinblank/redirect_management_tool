import { FormValidationController } from "./form-validation.js";

const ModalController = {
  clear() {
    const modal = document.querySelector(".modal-overlay");
    modal.remove();
  },

  show(action, elem) {
    const mainContent = document.getElementById("content");
    const tableName = document.querySelector(".page-section").dataset.tableName;
    // const itemId = elem ? elem.closest(".table-row").dataset.itemId : "";
    let itemId = "";
    if (elem && (action === "edit" || action === "disable")) {
      itemId = elem.closest(".table-row").dataset.itemId;
    } else if (action === "upload") {
      const urlParams = new URLSearchParams(window.location.search);
      itemId = urlParams.get("website_id");
      console.log(itemId);
    }

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
          const modalContent = xhr.responseText;
          mainContent.insertAdjacentHTML("beforeend", modalContent);

          const modalEl = document.querySelector("#modal");
          const form = modalEl.querySelector("form");
          const formIdSelector = "#" + form.id;

          new FormValidationController(formIdSelector);
        } else {
          console.error("Request failed with status: " + xhr.status);
        }
      }
    };

    xhr.send();
  },
};

export default ModalController;
