import ModalController from "./modal-controller.js";

export default function initDocumentEvents() {
  document.body.addEventListener("click", (e) => {
    const elem = e.target;
    const activeElements = Array.from(document.querySelectorAll(".active"));
    activeElements.forEach((activeElem) =>
      activeElem.classList.remove("active")
    );

    // for now... need to figure out how to close all when anywhere else is clicked
    // (for table)
    // const openMenus = Array.from(
    //   document.querySelectorAll(".more-actions-menu")
    // );
    // openMenus.forEach((menu) => menu.classList.remove("active"));

    // Notice banner
    if (elem.matches(".notice-banner-x-btn")) {
      elem.closest(".notice-banner").remove();
    }

    // Table more actions menu
    if (elem.matches(".more-actions-toggle")) {
      const openMenus = Array.from(
        document.querySelectorAll(".more-actions-menu")
      );
      openMenus.forEach((menu) => menu.classList.remove("active"));
      const menu = elem.nextElementSibling.classList.contains(
        "more-actions-menu"
      )
        ? elem.nextElementSibling
        : null;
      menu.classList.add("active");
    }

    // Modals
    if (elem.matches("#modal-cancel-btn")) {
      ModalController.clear();
    }

    if (elem.matches(".add-item-btn")) {
      ModalController.show("add");
    }

    if (elem.matches(".edit-item-btn")) {
      ModalController.show("edit", elem);
    }

    if (elem.matches(".disable-item-btn")) {
      ModalController.show("disable", elem);
    }

    if (elem.matches("#upload-rules-btn")) {
      ModalController.show("upload");
    }

    if (elem.matches(".dropdown-toggle-btn")) {
      const dropdownMenu = elem.nextElementSibling.classList.contains(
        "dropdown-menu"
      )
        ? elem.nextElementSibling
        : null;
      dropdownMenu.classList.toggle("active");
    }
  });
}
