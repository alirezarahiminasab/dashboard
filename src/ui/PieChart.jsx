import React from "react";
import { PieChart, Pie, Cell } from "recharts";
import { GoArrowUpRight } from "react-icons/go";
import { AiFillLike } from "react-icons/ai";

const data1 = [
  { name: "Group A", value: 600 },
  { name: "Group B", value: 300 },
];
const COLORS1 = ["rgb(79, 70, 229)", "#eee"];
const data2 = [{ name: "Group A", value: 600 }];
const COLORS2 = ["#eee"];

export default function PieChartCard() {
  return (
    <div className="pie-chart">
      <Header />
      <Plot />
      <Footer />
    </div>
  );
}

function Header() {
  return (
    <div className="header">
      <div className="title">
        <p>Overall</p>
        <p>Performance</p>
      </div>
      <div className="label">
        <GoArrowUpRight className="icon" />
        <span>95</span>

        <span className="percent">%</span>
      </div>
    </div>
  );
}

function Plot() {
  return (
    <div className="plot">
      {/* <ResponsiveContainer width={width} height={height}> */}
      <PieChart width={300} height={170}>
        <Pie
          animationDuration={0}
          data={data2}
          // cx={120}
          cy={150}
          startAngle={180}
          endAngle={0}
          innerRadius={110}
          outerRadius={145}
          // fill="#8884d8"
          paddingAngle={1}
          cornerRadius={8}
          dataKey="value"
        >
          {data2.map((entry, index) => (
            <Cell
              key={`cell-${index}`}
              fill={COLORS2[index % COLORS2.length]}
            />
          ))}
        </Pie>
        <Pie
          animationDuration={700}
          data={data1}
          // cx={120}
          cy={150}
          startAngle={180}
          endAngle={0}
          innerRadius={110}
          outerRadius={145}
          // fill="#8884d8"
          paddingAngle={1}
          cornerRadius={8}
          dataKey="value"
        >
          {data1.map((entry, index) => (
            <Cell
              key={`cell-${index}`}
              fill={COLORS1[index % COLORS1.length]}
            />
          ))}
        </Pie>
      </PieChart>
      {/* </ResponsiveContainer> */}

      <div className="inner-text">
        <h2>Avg Health Score</h2>
        <div className="container">
          <h1>468</h1>
          <div className="label">
            <AiFillLike />
            Perfect
          </div>
        </div>
      </div>
    </div>
  );
}
function Footer() {
  return (
    <div className="footer">
      <p>AmirHossein is healthier than 95% people </p>
      <button className="btn">Check Full Report</button>
    </div>
  );
}
