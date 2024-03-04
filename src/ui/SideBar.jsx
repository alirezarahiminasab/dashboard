import { useState } from "react";
import { NavLink } from "react-router-dom";

import { BiLogOut } from "react-icons/bi";
import { TbSettings, TbSettingsFilled } from "react-icons/tb";
import { navListData } from "../data/navListData";

export default function SideBar() {
  return (
    <aside className="sidebar">
      <NavList />
      <AccountCard />
    </aside>
  );
}

function NavList() {
  const [hover, setHover] = useState("Dashboard");
  return (
    <nav>
      <ul className="nav-list">
        {navListData.map(({ name, icon1, icon2, path = "" }) => (
          <li
            key={name}
            onMouseEnter={() => setHover(name)}
            onMouseLeave={() => setHover("")}
          >
            <NavLink to={path} className="nav-item">
              {name === "Dashboard" && icon2}
              {name !== "Dashboard" && name === hover && icon2}
              {name !== "Dashboard" && name !== hover && icon1}
              <span>{name}</span>
            </NavLink>
          </li>
        ))}
      </ul>
    </nav>
  );
}

function AccountCard() {
  return (
    <div className="account-card">
      <img src="avatar4.png" className="avatar" />
      <h1>Rahimi Nasab</h1>
      <h2>Web Developer</h2>
      <div className="btns">
        <button className="btn">
          <TbSettings />
          {/* <TbSettingsFilled /> */}
        </button>
        <button className="btn">
          <BiLogOut />
        </button>
      </div>
    </div>
  );
}
