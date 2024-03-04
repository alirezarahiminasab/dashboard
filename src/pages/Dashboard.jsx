import Table from "../ui/Table";

import React from "react";

import PieChartCard from "../ui/PieChart";
// import BarChartCard from "../ui/BarChart";
import BarChartCard from "../ui/BarChart";
import ProfileCard from "../ui/Profile";
// import "../ui/BarChartTest";

export default function Dashboard() {
  return <ScrollWindow />;
}

function ScrollWindow() {
  return (
    <div className="dashboard">
      <PieChartCard />
      <BarChartCard />
      <ProfileCard />
      <Table />
    </div>
  );
}
// change
