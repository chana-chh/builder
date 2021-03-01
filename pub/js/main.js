/* DROPDOWN */
let dropdownTogglers = document.querySelectorAll(".dropdown-toggle");

const closeAllDropdowns = () => {
  if (dropdownTogglers) {
    let dropdownContents = document.querySelectorAll(".dropdown-content");
    dropdownContents.forEach(dropdownContent => {
      dropdownContent.previousElementSibling.classList.remove("drop-hover");
      dropdownContent.classList.remove("show");
    });
  }
};

if (dropdownTogglers) {
  dropdownTogglers.forEach(dropdownToggle => {
    dropdownToggle.onclick = e => {
      let dropdownContent = dropdownToggle.nextElementSibling;
      let visible = dropdownContent.classList.contains("show");
      closeAll();
      visible ? dropdownContent.classList.remove("show") : dropdownContent.classList.add("show");
      dropdownContent.onclick = e => {
        e.stopPropagation();
      };
      e.stopPropagation();
    };
  });
}

/* MODAL */

let modalOpeners = document.querySelectorAll(".open-modal");

if (modalOpeners) {
  modalOpeners.forEach(el => {
    let modalId = el.dataset.modal;
    let modal = document.querySelector(modalId);
    let span = modal.querySelector(".close");
    let modalClose = modal.querySelector(".modal-close");

    el.onclick = () => {
      modal.classList.add("show");
    };

    span.onclick = () => {
      modal.classList.remove("show");
    };

    if (modalClose) {
      modalClose.onclick = () => {
        modal.classList.remove("show");
      };
    }

    modal.onclick = e => {
      if (event.target == modal) {
        modal.classList.remove("show");
      }
    };
  });
}

/* DROPDOWN NAVBAR */
let hamburger = document.querySelector(".navbar .hamburger");
let navbarSubmenus = document.querySelectorAll(".navbar .nav .submenu");

if (hamburger) {
  hamburger.onclick = () => {
    let nav = document.querySelector(".nav");
    hamburger.classList.toggle("change");
    nav.classList.toggle("active");
  };
}

const closeAllSubs = () => {
  if (navbarSubmenus) {
    navbarSubmenus.forEach(sm => {
      sm.classList.remove("active");
    });
  }
};

if (navbarSubmenus) {
  navbarSubmenus.forEach(sm => {
    sm.querySelector("a").onclick = () => {
      let open = sm.classList.contains("active");
      closeAllSubs();
      open ? sm.classList.remove("active") : sm.classList.add("active");
      sm.onclick = e => {
        e.stopPropagation();
      };
    };
  });
}

window.onclick = () => {
  closeAllSubs();
  closeAllDropdowns();
};

/* FLASH */
let flashMessages = document.querySelectorAll(".flash");

if (flashMessages) {
  flashMessages.forEach(msg => {
    let close = msg.querySelector(".close");
    close.onclick = () => {
      msg.classList.add("hide");
    };
  });
}

/* PAGINATION GO TO */
let pgnGoTos = document.querySelectorAll(".pgn-goto-select");

if (pgnGoTos) {
  pgnGoTos.forEach(pgn => {
    pgn.onchange = () => {
      location = pgn.value;
    };
  });
}

/* AJAX */

/**
 * Vraca sva polja forme u obliku JSON-a
 * @param {string} formId id forme koja se pretvara u JSON
 */
const formToJSON = formId => {
  const form = document.getElementById(formId);
  const fd = new FormData(form);
  let jsonObject = {};
  fd.forEach((value, key) => {
    if (!jsonObject.hasOwnProperty(key)) {
      jsonObject[key] = value;
      return;
    }
    if (!Array.isArray(jsonObject[key])) {
      jsonObject[key] = [jsonObject[key]];
    }
    jsonObject[key].push(value);
  });
  return jsonObject;
};

// XMLHttpRequest

/**
 * Salje GET ili POST zahtev
 * @param {string} method
 * @param {string} url
 * @param {string|JSON} data form id | JSON object
 */
const sendAjaxRequest = (method, url, data) => {
  const promise = new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url);
    xhr.responseType = "json";
    if (data) {
      if (typeof data === "string") {
        data = formToJSON(data);
      } else {
        addCsrfToken(data);
      }
      xhr.setRequestHeader("Content-Type", "application/json");
    }
    xhr.onload = () => {
      if (xhr.status >= 400) {
        reject(xhr.response);
      } else {
        resolve(xhr.response);
      }
    };
    xhr.onerror = () => {
      reject("Prso ajax!");
    };
    xhr.send(JSON.stringify(data));
  });
  return promise;
};

const updateCsrfToken = data => {
  const csrfNames = document.querySelectorAll(".csrf_name");
  const csrfValues = document.querySelectorAll(".csrf_value");
  csrfNames.forEach(name => {
    name.value = data.csrf_name;
  });
  csrfValues.forEach(val => {
    val.value = data.csrf_value;
  });
};

const addCsrfToken = data => {
  const csrfName = document.querySelector(".csrf_name");
  const csrfValue = document.querySelector(".csrf_value");
  data.csrf_name = csrfName.value;
  data.csrf_value = csrfValue.value;
};
