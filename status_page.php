<!DOCTYPE html>
<html>
<head>
  <title>Sales Data Visualization</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    canvas {
      display: block;
      margin: 20px 0;
    }
  </style>
</head>
<body>
  <h1>Sales Data Visualization</h1>

	<?php
	// Include the SQL connection script
	include 'chart_functions.php';
	include 'sql_functions.php';

	// Retrieve the data from the item_report function
	$data = category_charged_report();

	// Get the names of the columns in the array
	$columnNames = array_keys($data[0]);

	// Get the values from the first column for labels
	$labels = array_column($data, $columnNames[0]);
	
	// Exclude the first column from the chart generation
	$columnNames = array_slice($columnNames, 1);

	// Loop through the columns (except the first) and generate a line chart for each one
	foreach ($columnNames as $columnName) {
		$dataForChart = array_column($data, $columnName);

		// Generate the line chart
		generatePieChart($columnName, $labels, $dataForChart, $columnName);
	}
	copy_table($data);


	//Second report


	reset($data);
	reset($labels);
	reset($columnNames);
	reset($dataForChart);
	// Retrieve the data from the item_report function
	$data = new_boats_report();
	var_dump($data);
	// Get the names of the columns in the array
	$columnNames = array_keys($data[0]);

	// Get the values from the first column for labels
	$labels = array_column($data, $columnNames[0]);
	
	// Exclude the first column from the chart generation
	$columnNames = array_slice($columnNames, 1);

	// Loop through the columns (except the first) and generate a line chart for each one
	foreach ($columnNames as $columnName) {
		$dataForChart = array_column($data, $columnName);

		// Generate the line chart
		generateBarChart($columnName, $labels, $dataForChart, $columnName
		);
	}
	copy_table($data);

	
    ?>
</body>
</html>