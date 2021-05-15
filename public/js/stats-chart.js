'use strict';

let hits = [[0,0]];

(async () => {
  const data = await loadData({method: `GET`});
  hits = data.map((item) => [item.hour, item.count]);
  init();
})();


function init() {
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
}

function drawChart() {

  const data = new google.visualization.DataTable();
  data.addColumn('number', 'Час');
  data.addColumn('number', 'Hits');
  data.addRows(hits);


  const options = {
    title: 'Количество посещений',
    curveType: 'function',
    legend: {position: 'right', textStyle: {color: 'blue', fontSize: 16}},
    pointsVisible: true,
    pointShape: 'diamond',
  };

  const chart = new google.visualization.LineChart(document.getElementById('chart_div'));

  chart.draw(data, options);
}
