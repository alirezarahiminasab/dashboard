import { useEffect, useRef } from "react";

export default function useOutsideClick(handler) {
  const options = useRef(null);
  const select = useRef(null);

  const outsideClickHandler = (e) => {
    if (e.target.closest(".window") !== options.current) {
      e.target.closest(".select") === select.current && e.stopPropagation();
      handler();
      //   setOpen(false);
    }
  };

  useEffect(() => {
    document.addEventListener("click", outsideClickHandler, true);
    return document.removeEventListener("click", outsideClickHandler);
  }, []);

  return [select, options];
}
