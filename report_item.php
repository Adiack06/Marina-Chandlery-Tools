<<!DOCTYPE html>
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
    include 'sql.php';
	include 'chart_functions.php';
    // Get the user input
    $partNo = $_POST['partNo'];

    // Construct the SQL query
    $query = "SELECT YEAR(s.Date) AS Year,
                     SUM(s.`Quantity Sold`) AS TotalQuantitySold,
                     SUM(s.Cost) AS TotalCost,
                     SUM(s.`Gross Margin`) AS SumOfGrossMargin
              FROM sales s
              WHERE s.`Part No` LIKE '%$partNo%'";

    $query .= " GROUP BY YEAR(s.Date)
                ORDER BY YEAR(s.Date)";

    // Execute the SQL query
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      // Initialize arrays for chart data
      $years = [];
      $quantitySold = [];
      $totalCost = [];
      $grossMargin = [];

      // Fetch and store the data
      while ($row = $result->fetch_assoc()) {
        $years[] = $row['Year'];
        $quantitySold[] = $row['TotalQuantitySold'];
        $totalCost[] = $row['TotalCost'];
        $grossMargin[] = $row['SumOfGrossMargin'];
      }

      generateLineChart('quantitySoldChart', $years, $quantitySold, 'Quantity Sold');
      generateLineChart('totalCostChart', $years, $totalCost, 'Total Cost');
      generateLineChart('grossMarginChart', $years, $grossMargin, 'Gross Margin');

            // Create a table with the data
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
	mysqli_data_seek($result, 0); // Reset result pointer
	while ($row = $result->fetch_assoc()) {
	  echo "<tr>
			  <td>".$row['Year']."</td>
			  <td>".$row['TotalQuantitySold']."</td>
			  <td>".$row['TotalCost']."</td>
			  <td>".$row['SumOfGrossMargin']."</td>
			</tr>";
	}
	echo "</tbody></table>";

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

    // Close the database connection
    $conn->close();
  }
  ?>
</body>
</html>