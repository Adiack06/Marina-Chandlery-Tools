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


	copy_table($data);
  }
    ?>
</body>
</html>