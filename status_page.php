<!DOCTYPE html>
<html>
<head>
  <title>Marina Information</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" type="text/css" href="styles/report.css">
</head>
<body>
  <h1>Marina Information</h1>

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
	echo '<div class="grid-container">';
	foreach ($columnNames as $columnName) {
		$dataForChart = array_column($data, $columnName);

		// Generate the line chart
		echo '<div class="graph-container">';
		generatePieChart($columnName, $labels, $dataForChart, $columnName);
		echo '</div>';
	}
	echo '</div>';
	copy_table($data);


	//Second report


	reset($data);
	reset($labels);
	reset($columnNames);
	reset($dataForChart);
	// Retrieve the data from the item_report function
	$data = new_boats_report();
	// Get the names of the columns in the array
	$columnNames = array_keys($data[0]);

	// Get the values from the first column for labels
	$labels = array_column($data, $columnNames[0]);
	
	// Exclude the first column from the chart generation
	$columnNames = array_slice($columnNames, 1);

	// Loop through the columns (except the first) and generate a line chart for each one
	echo '<div class="grid-container">';
	foreach ($columnNames as $columnName) {
		$dataForChart = array_column($data, $columnName);

		// Generate the line chart
		echo '<div class="graph-container">';
		generateBarChart($columnName, $labels, $dataForChart, $columnName);
		echo '</div>';
	}
	echo '</div>';
	copy_table($data);

	//Third report


	reset($data);
	reset($labels);
	reset($columnNames);
	reset($dataForChart);
	// Retrieve the data from the item_report function
	$data = vists_country_report();
	// Get the names of the columns in the array
	$columnNames = array_keys($data[0]);

	// Get the values from the first column for labels
	$labels = array_column($data, $columnNames[0]);
	
	// Exclude the first column from the chart generation
	$columnNames = array_slice($columnNames, 1);

	// Loop through the columns (except the first) and generate a line chart for each one
	echo '<div class="grid-container">';
	foreach ($columnNames as $columnName) {
		$dataForChart = array_column($data, $columnName);

		// Generate the line chart
		echo '<div class="graph-container">';
		generateDoughnutChart($columnName, $labels, $dataForChart, $columnName);
		echo '</div>';
	}
	echo '</div>';
	copy_table($data);
	
    ?>
</body>
</html>