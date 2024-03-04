import { IoIosArrowDropdown } from "react-icons/io";
import { filterFields, filterFields2 } from "../data/tableData";
import React, { useEffect } from "react";
import * as echarts from "echarts";

import {
  BarChart,
  Bar,
  Rectangle,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
} from "recharts";

import FilterMenu from "./FilterMenu";
import FilterButtons from "./FilterButtons";
import { barchartMenuData } from "../data/barchartData";
export default function BarChartCard() {
  return (
    <div className="bar-chart">
      <Header />
      {/* <Filter /> */}
      <Plot />
    </div>
  );
}

function Header() {
  return (
    <div className="header">
      <p className="title">Analytics</p>
      <Filter />

      <FilterMenu
        urlParamName="barchart-menu"
        items={barchartMenuData}
        icon={<IoIosArrowDropdown />}
      />
    </div>
  );
}

function Filter() {
  return (
    <div className="filter">
      <FilterButtons
        urlParamName="barchart-btn"
        filterFields={filterFields2}
        numButtons={2}
      />
    </div>
  );
}

const data = [
  {
    day: "Sat",
    bpm: 135,
  },
  {
    day: "Sun",
    bpm: 150,
  },
  {
    day: "Mon",
    bpm: 120,
  },
  {
    day: "Tue",
    bpm: 140,
  },
  {
    day: "Wed",
    bpm: 167,
  },
  {
    day: "Thu",
    bpm: 135,
  },
  {
    day: "Fri",
    bpm: 120,
  },
];

const Plot = () => {
  useEffect(() => {
    // Initialize echarts instance
    const myChart = echarts.init(document.getElementById("main"));
    myChart.resize();
    // Specify configurations and data for the chart
    const option = {
      tooltip: {
        trigger: "item",
        // responsive: true,
        height: "200px",
        position: "top",
        formatter: "{c} {a}",
        backgroundColor: "rgb(79, 70, 229)",
        padding: 4,
        textStyle: {
          color: "white",
          fontSize: 13,
        },
      },
      calculable: true,
      xAxis: [
        {
          type: "category",
          data: data.map((d) => d.day),
        },
      ],
      yAxis: [
        {
          type: "value",
        },
      ],
      series: [
        {
          name: "bpm",
          type: "bar",
          data: data.map((d) => d.bpm),

          emphasis: {
            itemStyle: {
              color: "rgb(79, 70, 229)", // Set different color for hovered bars
              markPoint: {
                data: [
                  {
                    type: "item",
                    name: "min",
                    symbol: "circle",
                    symbolSize: 15,
                    itemStyle: {
                      color: "rgb(79, 70, 229)",
                      borderWidth: 3.5,
                      borderColor: "white",
                    },
                  },
                ],
              },
            },
          },
          itemStyle: {
            color: function (params) {
              // Define color stops for the gradient
              let colorStops = [
                { offset: 0, color: "rgb(79, 70, 229)" }, // Start color
                { offset: 0.01, color: "rgb(79, 70, 229)" }, // Start color
                { offset: 0.02, color: "white" }, // First slice
                { offset: 0.03, color: "rgb(79, 70, 229,.5)" }, // Second slice
                { offset: 1, color: "white" }, // End color
              ];

              // Create gradient color for each bar
              return new echarts.graphic.LinearGradient(0, 0, 0, 1, colorStops);
            },
          },
          markPoint: {
            data: [
              {
                type: "max",
                name: "min",
                symbol: "circle",
                symbolSize: 15,
                itemStyle: {
                  color: "rgb(79, 70, 229)",
                  borderWidth: 3.5,
                  borderColor: "white",
                },
                label: {
                  show: false,
                },
              },
              {
                type: "max",
                name: "Max",
                symbol: "pin",
                symbolOffset: [0, -10],
                symbolSize: 40,
                itemStyle: {
                  color: "rgb(79, 70, 229)",
                  borderWidth: 0,
                  borderColor: "white",
                },
                label: {
                  show: false,
                },
              },
              {
                type: "max",
                name: "min",
                symbol: "roundRect",
                symbolSize: [65, 30],
                symbolOffset: [0, -35],
                itemStyle: {
                  color: "rgb(79, 70, 229)",
                  borderWidth: 0,
                  borderColor: "white",
                },
                label: {
                  show: true,
                  formatter: function (params) {
                    return `${params.value} bpm`; // Display the series name as the label
                  },
                },
              },
            ],
          },

          markLine: {
            data: [{ type: "max", name: "max value" }],
            label: {
              show: false,
            },
            symbol: "none",
            lineStyle: {
              color: "gray",
              type: "dashed",
              width: 2,
            },
          },
        },
      ],
    };

    // Use the specified configurations and data for the chart
    myChart.setOption(option);

    // Clean up: Destroy echarts instance when component unmounts
    return () => {
      myChart.dispose();
    };
  }, []); // Empty dependency array ensures this effect runs only once after initial render

  return <div id="main" style={{ width: "100%", height: "100%" }}></div>;
}; // function Plot() {
//   return (
//     <div className="plot">
//       <BarChart width={400} height={300} data={data}>
//         <XAxis dataKey="day" />
//         <YAxis />
//         <Tooltip />
//         <Bar
//           dataKey="bpm"
//           // fill="rgb(79, 70, 229)"
//           activeBar={<Rectangle fill="pink" stroke="blue" />}
//         />
//       </BarChart>
//     </div>
//   );
// }
