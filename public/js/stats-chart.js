'use strict';

const chartElement = document.getElementById('chart');
let hits = [];

google.charts.load('current', {'packages': ['corechart']});
google.charts.setOnLoadCallback(load);

async function load() {
  const data = await loadData({method: `GET`});
  hits = data.map((item) => [item.hour, item.count]);
  drawChart();
}

function drawChart() {
  const data = new google.visualization.DataTable();
  data.addColumn('number', 'Hour');
  data.addColumn('number', 'Hits');
  data.addRows(hits);

  const options = {
    title: 'Количество посещений',
    curveType: 'function',
    legend: {position: 'right', textStyle: {color: 'blue', fontSize: 16}},
    pointsVisible: true,
    pointShape: 'diamond',
    hAxis: {gridlines: { count: 0 } }
  };

  const chart = new google.visualization.LineChart(chartElement);
  chart.draw(data, options);
}


