import { IoIosArrowDropdown } from "react-icons/io";
import FilterMenu from "./FilterMenu";

import {
  ContentData,
  headers,
  filterFields,
  tableMenuData,
} from "../data/tableData";
import FilterButtons from "./FilterButtons";

export default function TableCard() {
  return (
    <div className="table">
      <Filters />
      <Headers />
      <Content />
    </div>
  );
}

function Filters() {
  return (
    <div className="filter">
      <FilterButtons
        urlParamName="table-btn"
        filterFields={filterFields}
        numButtons={4}
      />
      <FilterMenu
        urlParamName="table-menu"
        items={tableMenuData}
        icon={<IoIosArrowDropdown />}
      />
    </div>
  );
}

function Headers() {
  return (
    <div className="table__row">
      {headers.map((h) =>
        h.icon ? (
          <button key={h.name}>
            {h.name}
            {h.icon}
          </button>
        ) : (
          <div key={h.name}>{h.name}</div>
        )
      )}
    </div>
  );
}

function Content() {
  return ContentData.map((row, i) => (
    <div key={row[0] + i} className="table__row">
      {row.map((col, j) => (
        <div key={j + col} className={j === 4 ? "label" : ""}>
          {col}
        </div>
      ))}
    </div>
  ));
}
