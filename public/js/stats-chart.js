'use strict';

const chartLineElement = document.getElementById('chart-line');
const chartPieElement = document.getElementById('chart-pie');
let data = null;

(async () => {
  data = await loadData();
})();

google.charts.load('current', {'packages': ['corechart']});
google.charts.setOnLoadCallback(draw);

async function draw() {
  if (null === data) {
    data = await loadData();
  }

  const {hours, cities} = data;

  const hits = hours.map((item) => [item.hour, item.count]);
  const citiesChunks = cities.map((item) => [item.city, item.count]);

  drawLineChart(hits);
  drawPieChart(citiesChunks);
  data = null;
}

function drawLineChart(hits) {
  const data = new google.visualization.DataTable();
  data.addColumn('number', 'Hour');
  data.addColumn('number', 'Hits');
  data.addRows(hits);

  const date = new Date().toDateString();
  const options = {
    title: `Количество посещений ${date}` ,
    curveType: 'function',
    legend: {position: 'right', textStyle: {color: 'blue', fontSize: 16}},
    pointsVisible: true,
    pointShape: 'diamond',
    hAxis: {gridlines: { count: 0 } },
  };

  const chart = new google.visualization.LineChart(chartLineElement);
  chart.draw(data, options);
}

function drawPieChart(chunks) {
  const data = new google.visualization.DataTable();
  data.addColumn('string', 'Cities');
  data.addColumn('number', 'count');
  data.addRows(chunks);

  const options = {
    'title':'Общий процент посещений по городам',
    'width':600,
    'height':400,
    is3D: true
  };

  const chart = new google.visualization.PieChart(chartPieElement);
  chart.draw(data, options);
}


