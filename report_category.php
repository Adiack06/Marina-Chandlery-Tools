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
    <label for="category">Category Number:</label>
    <select name="category" id="category">
      <?php
      // Include the SQL connection script
      include 'sql.php';

      // Construct the SQL query to fetch category numbers and descriptions
      $query = "SELECT Category, `Category Desc` FROM sales GROUP BY Category";
      $result = $conn->query($query);

      while ($row = $result->fetch_assoc()) {
        $categoryNumber = $row['Category'];
        $description = $row['Category Desc'];
        echo "<option value='$categoryNumber'>$categoryNumber - $description</option>";
      }

      // Close the database connection
      $conn->close();
      ?>
    </select>
    <br>
    <label for="partDesc">Part Desc:</label>
    <input type="text" name="partDesc" id="partDesc">
    <br>
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

    // Get the user input
	
	$data = category_report($_POST['partNo'],$_POST['category'],$_POST['partDesc']);


// Initialize arrays for chart data
    $rows = [];
    $quantitySold = [];
    $totalCost = [];
    $grossMargin = [];

    // Extract the data from the 3D array
    foreach ($data as $yearData) {
        $rows[] = $yearData['Year'];
        $quantitySold[] = $yearData['TotalQuantitySold'];
        $totalCost[] = $yearData['TotalCost'];
        $grossMargin[] = $yearData['GrossMargin'];
    }

	generateLineChart('quantitySoldChart', $rows, $quantitySold, 'Quantity Sold');
	generateLineChart('totalCostChart', $rows, $totalCost, 'Total Cost');
	generateLineChart('grossMarginChart', $rows, $grossMargin, 'Gross Margin');

	copy_table($data);
	}
?>
</body>
</html>