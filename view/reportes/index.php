<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<button class="btn btn-success" onclick="grafica()">Gráfica de productos vendidos hoy</button>
	<!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
</div>
<script>
$(document).ready(function() {
	$.getScript("https://www.gstatic.com/charts/loader.js");
});

function grafica() {
	// Load the Visualization API and the corechart package.
  	google.charts.load('current', {'packages':['corechart']});

 	// Set a callback to run when the Google Visualization API is loaded.
  	google.charts.setOnLoadCallback(drawChart);
}

function drawChart() {
	var jsonData = $.ajax({
          url: "acciones/obtener_cantidad_productos_vendidos_hoy.php",
          dataType: "json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, {width: 600, height: 480});
}

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
// function drawChart() {
//     // Create the data table.
//     var data = new google.visualization.DataTable();
//     data.addColumn('string', 'Topping');
//     data.addColumn('number', 'Slices');
//     data.addRows([
//       ['Mushrooms', 3],
//       ['Onions', 1],
//       ['Olives', 1],
//       ['Zucchini', 1],
//       ['Pepperoni', 2]
//     ]);
    
//     // Set chart options
//     var options = {'title':'How Much Pizza I Ate Last Night',
//                    'width':400,
//                    'height':300};
    
//     // Instantiate and draw our chart, passing in some options.
//     var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
//     chart.draw(data, options);
// }

</script>