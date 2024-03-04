import { Outlet } from "react-router-dom";
import SideBar from "./SideBar";
import Header from "./Header";

export default function AppLayout() {
  return (
    <Body>
      <Logo />
      <Header />
      <SideBar />
      <Main>
        <Outlet />
      </Main>
    </Body>
  );
}

function Main({ children }) {
  return <div className="main">{children}</div>;
}

function Body({ children }) {
  return <div className="app-layout">{children}</div>;
}

function Logo() {
  return (
    <div className="logo-container">
      <img className="logo" src="logo.png" alt="Logo" />
      <span>Nexus</span>
    </div>
  );
}
