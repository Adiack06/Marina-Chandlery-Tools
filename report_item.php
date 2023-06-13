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

      // Generate line graphs using Chart.js
      $chartData = json_encode($years);
      $quantitySoldData = json_encode($quantitySold);
      $totalCostData = json_encode($totalCost);
      $grossMarginData = json_encode($grossMargin);

      echo "<canvas id='quantitySoldChart'></canvas>";
      echo "<canvas id='totalCostChart'></canvas>";
      echo "<canvas id='grossMarginChart'></canvas>";

      echo "<script>
              var years = $chartData;
              var quantitySoldData = $quantitySoldData;
              var totalCostData = $totalCostData;
              var grossMarginData = $grossMarginData;

              var quantitySoldChart = new Chart(document.getElementById('quantitySoldChart'), {
                type: 'line',
                data: {
                  labels: years,
                  datasets: [{
                    label: 'Quantity Sold',
                    data: quantitySoldData,
                    borderColor: 'blue',
                    fill: false
                  }]
                }
              });

              var totalCostChart = new Chart(document.getElementById('totalCostChart'), {
                type: 'line',
                data: {
                  labels: years,
                  datasets: [{
                    label: 'Total Cost',
                    data: totalCostData,
                    borderColor: 'green',
                    fill: false
                  }]
                }
              });

              var grossMarginChart = new Chart(document.getElementById('grossMarginChart'), {
                type: 'line',
                data: {
                  labels: years,
                  datasets: [{
                    label: 'Gross Margin',
                    data: grossMarginData,
                    borderColor: 'red',
                    fill: false
                  }]
                }
              });

              function copyToClipboard() {
                var table = document.createElement('table');
                var thead = document.createElement('thead');
                var tbody = document.createElement('tbody');

                var headerRow = document.createElement('tr');
                headerRow.innerHTML = '<th>Year</th><th>Total Quantity Sold</th><th>Total Cost</th><th>Gross Margin</th>';
                thead.appendChild(headerRow);
                table.appendChild(thead);

                var rows = document.getElementsByTagName('table')[0].getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (var i = 0; i < rows.length; i++) {
                  var newRow = document.createElement('tr');
                  var cells = rows[i].getElementsByTagName('td');
                  for (var j = 0; j < cells.length; j++) {
                    var newCell = document.createElement('td');
                    newCell.textContent = cells[j].textContent;
                    newRow.appendChild(newCell);
                  }
                  tbody.appendChild(newRow);
                }
                table.appendChild(tbody);

                document.body.appendChild(table);
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

                document.body.removeChild(table);
                window.getSelection().removeAllRanges();
              }

              var copyButton = document.createElement('button');
              copyButton.textContent = 'Copy Table Data';
              copyButton.addEventListener('click', copyToClipboard);
              document.body.appendChild(copyButton);
            </script>";
      // Create a table with the data
      echo "<h2>Table Data</h2>";
      echo "<table>
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

      // Close the database connection
      $conn->close();
    }
  }
  ?>
</body>
</html>