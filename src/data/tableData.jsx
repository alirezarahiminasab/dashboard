import { FaSortUp } from "react-icons/fa6";
import { FaSort } from "react-icons/fa";

export const tableMenuData = ["Recent", "Last 7 Days", "Last 30 Days"];

export const headers = [
  { name: "Test Name", icon: <FaSortUp /> },
  { name: "Referred by", icon: <FaSort /> },
  { name: "Date", icon: <FaSort /> },
  { name: "Comments" },
  { name: "Result" },
];

export const ContentData = [
  [
    "Electrocardiography",
    "Dr. Raficul islam",
    "28 Jan, 2024",
    "Good! Take rest",
    "Normal",
  ],
  [
    "Liver biopsy",
    "Dr. Fahim Ahmed",
    "12 Jan, 2024",
    "Waiting for diagram",
    "Hepatitis",
  ],
];

export const filterFields = [
  "Lab Reports",
  "Prescription",
  "Medication",
  "Dignosis",
  "custom field 5",
  "custom field 6",
  "custom field 7",
  "custom field 8",
  "custom field 9",
];

export const filterFields3 = [
  "Profile",
  "History",
  "field 3",
  "field 4",
  "field 5",
];

export const filterFields2 = [
  "Heart Rate",
  "Blood Pressure",
  "Glucose",
  "field 4",
  "field 5",
  "field 6",
  "field 7",
];
