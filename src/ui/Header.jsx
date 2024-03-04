import { MdOutlineNotificationsActive } from "react-icons/md";
import { TbMessage } from "react-icons/tb";

export default function Header() {
  return (
    <div className="header">
      <SearchBar />
      <Buttons />
    </div>
  );
}

function SearchBar() {
  return (
    <div className="search-bar">
      <input
        className="search-field"
        type="text"
        placeholder="Search patients, invoice, appointments etc"
      />
      <div className="search-icon">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          className="search-icon__svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          />
        </svg>
      </div>
    </div>
  );
}

function Buttons() {
  return (
    <div className="btns">
      <button className="btn">
        <MdOutlineNotificationsActive />
      </button>
      <button className="btn">
        <TbMessage />
      </button>
    </div>
  );
}
