/**
 * ChaSha Data Table
 */
class CSTable {
  options = {
    perPage: [10, 20, 50]
  };
  columns = {};
  data = {};
  page = 1;
  perPage = 10;
  search = "";
  searchColumns = [];
  sortColumn = "";
  sortOrder = "";

  constructor(table, options) {
    this.table = table;
    this.tbody = table.querySelector("tbody");
    this.setOptions(options);
    this.addTopBar();
    const ths = this.table.querySelectorAll("thead>tr>th");
    this.setColumns(ths);
    this.ajax();
  }

  setOptions(options) {
    for (let [key, value] of Object.entries(options)) {
      this.options[key] = value;
    }
    this.perPage = this.options.perPage[0];
  }

  setColumns(ths) {
    if (Object.keys(this.columns).length === 0) {
      ths.forEach(th => {
        const ds = th.dataset;
        this.columns[ds.name] = {};
        if (ds.hasOwnProperty("sort")) {
          th.classList.add("color-blue-light");
          th.style.cursor = "pointer";
          this.columns[ds.name].sort = true;
          this.columns[ds.name].order = 0;
          th.onclick = () => {
            this.clearOrder(ths);
            const name = ds.name;
            const order = this.columns[name].order;
            if (order === 0) {
              this.columns[name].order = 1;
              th.classList.remove("color-blue-light");
              th.classList.add("color-green-light");
              this.sortColumn = name;
              this.sortOrder = "ASC";
            } else if (order === 1) {
              this.columns[name].order = 2;
              th.classList.remove("color-green-light");
              th.classList.add("color-red-light");
              this.sortColumn = name;
              this.sortOrder = "DESC";
            } else {
              this.columns[name].order = 0;
              th.classList.remove("color-red-light");
              th.classList.add("color-blue-light");
              this.sortColumn = "";
              this.sortOrder = "";
            }
            this.page = 1;
            this.ajax();
          };
        } else {
          this.columns[ds.name].sort = false;
        }
        if (ds.hasOwnProperty("search")) {
          th.classList.add("bg-orange");
          this.columns[ds.name].search = true;
          this.searchColumns.push(ds.name);
        } else {
          this.columns[ds.name].search = false;
        }
      });
    }
  }

  clearOrder(ths) {
    this.page = 1;
    ths.forEach(th => {
      const ds = th.dataset;
      if (this.columns[ds.name].sort) {
        th.classList.remove("color-red-light");
        th.classList.remove("color-green-light");
        th.classList.add("color-blue-light");
      }
    });
  }

  addTopBar() {
    const topBar = document.createElement("div");
    topBar.classList.add("row");
    const c1 = document.createElement("div");
    c1.classList.add("col-1");
    const perPage = this.createPerPage();
    c1.appendChild(perPage);
    perPage.onchange = () => {
      this.perPage = perPage.value;
      this.page = 1;
      this.ajax();
    };
    const c2 = document.createElement("div");
    c2.classList.add("col-7");
    const c3 = document.createElement("div");
    c3.classList.add("col-4");
    const search = document.createElement("input");
    search.setAttribute("type", "text");
    search.onkeyup = e => {
      if (e.keyCode === 13) {
        e.preventDefault();
        if (search.value === "") {
          search.classList.remove("bg-red-light");
        } else {
          search.classList.add("bg-red-light");
        }
        this.search = search.value;
        this.page = 1;
        this.ajax();
      }
      if (e.key === "Escape") {
        e.preventDefault();
        search.classList.remove("bg-red-light");
        search.value = "";
        this.search = "";
        this.page = 1;
        this.ajax();
      }
    };
    c3.appendChild(search);
    topBar.appendChild(c1);
    topBar.appendChild(c2);
    topBar.appendChild(c3);
    this.table.before(topBar);
  }

  createPerPage() {
    const pp = this.options.perPage;
    const el = document.createElement("select");
    pp.forEach(o => {
      const option = document.createElement("option");
      option.setAttribute("value", o);
      option.innerText = o;
      el.appendChild(option);
    });
    return el;
  }

  addBottomBar() {
    const bb = document.querySelector(".pagination-bar");
    if (bb) {
      bb.remove();
    }
    const bottomBar = document.createElement("div");
    bottomBar.classList.add("pagination-bar");
    const pgn = this.createPgn();
    const pgnText = this.createPgnText();
    const pgnGoTo = this.createPgnGoTo();
    bottomBar.appendChild(pgn);
    bottomBar.appendChild(pgnText);
    bottomBar.appendChild(pgnGoTo);
    this.table.after(bottomBar);
  }

  createPgn() {
    const ul = document.createElement("ul");
    ul.classList.add("pgn");
    this.data.links.buttons.forEach(btn => {
      const li = document.createElement("li");
      const a = document.createElement("a");
      a.innerText = btn.page;
      if (btn.current) {
        li.classList.add("current");
      } else {
        a.setAttribute("href", btn.url);
      }
      a.onclick = e => {
        e.preventDefault();
        let pg = 1;
        if (a.innerText === "<") {
          pg = this.data.links.prev_page;
        } else if (a.innerText === ">") {
          pg = this.data.links.next_page;
        } else {
          pg = Number(a.innerText);
        }
        this.page = pg;
        this.ajax();
      };
      li.appendChild(a);
      ul.appendChild(li);
    });
    return ul;
  }

  createPgnText() {
    const div = document.createElement("div");
    div.classList.add("pgn-text");
    div.innerText = `Strana ${this.data.links.current_page} od ${this.data.links.total_pages}. Zapisi od ${this.data.links.row_from} do ${this.data.links.row_to} od ukupno ${this.data.links.total_rows} zapisa`;
    return div;
  }

  createPgnGoTo() {
    const div = document.createElement("div");
    div.classList.add("pgn-goto");
    const sel = document.createElement("select");
    sel.classList.add("pgn-goto-select");
    this.data.links.select.forEach(opt => {
      const option = document.createElement("option");
      option.setAttribute("value", opt.page);
      if (opt.page == this.data.links.current_page) {
        option.setAttribute("selected", "selected");
      }
      option.innerText = opt.page;
      sel.appendChild(option);
    });
    sel.onchange = () => {
      this.page = Number(sel.value);
      this.ajax();
    };
    div.appendChild(sel);
    return div;
  }

  ajax() {
    sendAjaxRequest("POST", this.options.url, {
      page: this.page,
      perPage: this.perPage,
      search: this.search,
      columns: this.searchColumns,
      sortColumn: this.sortColumn,
      sortOrder: this.sortOrder
    }).then(data => {
      updateCsrfToken(data);
      this.data = data;
      this.tbody.innerHTML = data.tbody;
      this.addBottomBar();
    });
  }
}
