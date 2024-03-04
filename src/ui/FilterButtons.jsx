import FilterMenu from "./FilterMenu";
import { useEffect } from "react";

import { useSearchParams } from "react-router-dom";

export default function FilterButtons({
  urlParamName,
  filterFields,
  numButtons,
}) {
  const [params, setParams] = useSearchParams();
  const currentParam = params.get(urlParamName) || filterFields[0];

  useEffect(() => {
    updateParam(urlParamName, filterFields[0]);
  }, []);

  function updateParam(key, value) {
    const newParams = new URLSearchParams(params);
    newParams.set(key, value);
    setParams(newParams);
  }

  return (
    <div className="filter__btns">
      {filterFields.slice(0, numButtons).map((field, i) => (
        <button
          key={i + field}
          className={`btn ${currentParam === field && "active"}`}
          onClick={() => updateParam(urlParamName, field)}
        >
          {field}
        </button>
      ))}
      <FilterMenu
        updateParam={updateParam}
        items={filterFields.slice(numButtons)}
        btnTitle={`+${filterFields.length - numButtons}`}
        urlParamName={urlParamName}
      />
    </div>
  );
}
