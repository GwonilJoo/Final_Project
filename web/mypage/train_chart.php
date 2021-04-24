<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      //google.charts.setOnLoadCallback(drawChart);

      var chart_data;

      function drawChart() {
        // var data = google.visualization.arrayToDataTable([
        //   ['iter', 'loss'],
        //   [1,  1],
        //   [2,  0.9],
        //   [3,  0.7],
        //   [4,  0.4]
        // ]);
        var data = google.visualization.arrayToDataTable(chart_data)

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }

      function loadData() {
        chart_data = [['iter', 'loss']];
        $.getJSON("../../sample.json", function(json) {
          for(var i=0;i<json.length;i++){
            chart_data.push(json[i]);
          }
          google.charts.setOnLoadCallback(drawChart);
        });
      }

      setInterval(function() {
         loadData();
      }, 500);

    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  </body>
</html>
