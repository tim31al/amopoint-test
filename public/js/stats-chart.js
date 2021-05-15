'use strict';

let hits = [[0,0]];

(async () => {
  const data = await loadData({method: `GET`});
  hits = data.map((item) => [item.hour, item.count]);
})();

google.charts.load('current', {'packages':['line']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

  const data = new google.visualization.DataTable();
  data.addColumn('number', 'Час');
  data.addColumn('number', 'Хиты');


  data.addRows(hits);

  const options = {
    chart: {
      title: 'Статистика посещения',
    },
    width: 900,
    height: 500
  };

  const chart = new google.charts.Line(document.getElementById('chart_div'));

  chart.draw(data, google.charts.Line.convertOptions(options));
}
