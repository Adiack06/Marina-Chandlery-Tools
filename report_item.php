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

    // Initialize arrays for chart data
    $years = [];
    $quantitySold = [];
    $totalCost = [];
    $grossMargin = [];

    // Extract the data from the 3D array
    foreach ($data as $yearData) {
        $years[] = $yearData['Year'];
        $quantitySold[] = $yearData['TotalQuantitySold'];
        $totalCost[] = $yearData['TotalCost'];
        $grossMargin[] = $yearData['GrossMargin'];
    }

    // Generate the line charts using the extracted data
    generateLineChart('quantitySoldChart', $years, $quantitySold, 'Quantity Sold');
    generateLineChart('totalCostChart', $years, $totalCost, 'Total Cost');
    generateLineChart('grossMarginChart', $years, $grossMargin, 'Gross Margin');


	echo "<h2>Table Data</h2>";
	echo "<table id='data-table'>
			<thead>
			  <tr>
				<th>Year</th>
				<th>Total Quantity Sold</th>
				<th>Total Cost</th>
				<th>Gross Margin</th>
			  </tr>
			</thead>
			<tbody>";
	foreach ($data as $row) {
		echo "<tr>
				<td>".$row['Year']."</td>
				<td>".$row['TotalQuantitySold']."</td>
				<td>".$row['TotalCost']."</td>
				<td>".$row['GrossMargin']."</td>
			  </tr>";
	}

	// Add a button to copy table data to clipboard
	echo "<button id='copyButton' onclick='copyToClipboard()'>Copy Table Data</button>";

	// JavaScript function to copy table data to clipboard
	echo "<script>
			function copyToClipboard() {
			  var table = document.getElementById('data-table');
			  var range = document.createRange();
			  range.selectNode(table);
			  window.getSelection().removeAllRanges();
			  window.getSelection().addRange(range);

			  var successful = document.execCommand('copy');
			  if (successful) {
				alert('Table data copied to clipboard!');
			  } else {
				alert('Failed to copy table data to clipboard.');
			  }

			  window.getSelection().removeAllRanges();
			}
		  </script>";
    } else {
      echo "<p>No data found for the selected criteria.</p>";
    }
  ?>
</body>
</html>