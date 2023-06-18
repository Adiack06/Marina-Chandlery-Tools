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
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<label for="partNo">Part No:</label>
	<input type="text" name="partNo" id="partNo">
	<br>
    <input type="submit" value="Generate Graphs">
  </form>

<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Include the SQL connection script
		include 'chart_functions.php';
		include 'sql_functions.php';

		// Retrieve the data from the item_report function
		$data = item_report($_POST['partNo']);

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
			generateLineChart($columnName, $labels, $dataForChart, $columnName);
		}
		copy_table($data);
	}

	
    ?>
</body>
</html>