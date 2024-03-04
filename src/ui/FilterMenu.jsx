import { useEffect, useState } from "react";
import { useSearchParams } from "react-router-dom";
import useOutsideClick from "../hooks/useOutsideClick";

export default function Menu({
  items,
  icon,
  btnTitle,
  urlParamName = "fakeName",
  updateParam,
}) {
  const [open, setOpen] = useState(false);
  const [params, setParams] = useSearchParams();
  const currentParam = params.get(urlParamName);

  const [option, setOption] = useState(() => currentParam || items[0]);
  const [selectRef, optionsRef] = useOutsideClick(() => setOpen(false));

  useEffect(() => {
    updateParam(urlParamName, items[0]);
  }, []);

  function updateParam(key, value) {
    const newParams = new URLSearchParams(params);
    newParams.set(key, value);
    setParams(newParams);
  }

  function itemClickHandler(item) {
    setOpen(false);
    setOption(item);
    updateParam(urlParamName, item);
  }

  return (
    <div ref={selectRef} className="filter__menu">
      <button
        className={`select ${items.includes(currentParam) && "active"}`}
        onClick={() => setOpen((open) => !open)}
      >
        {btnTitle || option}
        {!btnTitle && icon}
      </button>

      {open && (
        <OptionsWindow
          option={option}
          optionsRef={optionsRef}
          items={items}
          itemClickHandler={itemClickHandler}
        />
      )}
    </div>
  );
}

function OptionsWindow({ optionsRef, items, option, itemClickHandler }) {
  return (
    <ul ref={optionsRef} className="window">
      {items.map((item, i) => (
        <li
          className={`option ${item === option && "active"}`}
          key={i + item}
          onClick={() => itemClickHandler(item)}
        >
          {item}
        </li>
      ))}
    </ul>
  );
}
