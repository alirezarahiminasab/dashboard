import { BiSolidDashboard } from "react-icons/bi";
import {
  IoBag,
  IoBagOutline,
  IoPeopleOutline,
  IoPeopleSharp,
  IoPersonOutline,
  IoPersonSharp,
} from "react-icons/io5";
import { IoIosHelpCircleOutline, IoIosHelpCircle } from "react-icons/io";
import { LuLayoutDashboard } from "react-icons/lu";
import {
  HiOutlineClipboardDocumentList,
  HiMiniClipboardDocumentList,
} from "react-icons/hi2";

export const navListData = [
  {
    name: "Dashboard",
    icon1: <LuLayoutDashboard />,
    icon2: <BiSolidDashboard />,
    path: "/dashboard",
  },
  {
    name: "Appointments",
    icon1: <IoBagOutline />,
    icon2: <IoBag />,
    path: "",
  },
  {
    name: "Analytics",
    icon1: <IoPeopleOutline />,
    icon2: <IoPeopleSharp />,
    path: "",
  },
  {
    name: "Doctor",
    icon1: <IoPersonOutline />,
    icon2: <IoPersonSharp />,
    path: "",
  },
  {
    name: "Reports",
    icon1: <HiOutlineClipboardDocumentList />,
    icon2: <HiMiniClipboardDocumentList />,
    path: "",
  },
  {
    name: "Help",
    icon1: <IoIosHelpCircleOutline />,
    icon2: <IoIosHelpCircle />,
    path: "",
  },
];
