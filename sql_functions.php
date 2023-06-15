<?php
function item_report($partNo) {
    // Include the SQL connection script
    include 'sql.php';

    // Construct the SQL query
    $query = "SELECT YEAR(s.Date) AS Year,
                    SUM(s.`Quantity Sold`) AS TotalQuantitySold,
                    SUM(s.Cost) AS TotalCost,
                    SUM(s.`Gross Margin`) AS SumOfGrossMargin
              FROM sales s
              WHERE s.`Part No` LIKE '%$partNo%'
              GROUP BY YEAR(s.Date)
              ORDER BY YEAR(s.Date)";

    // Execute the SQL query
    $result = $conn->query($query);

    // Initialize the 3D array for storing the data
    $data = array();

    if ($result->num_rows > 0) {
        // Fetch and store the data
        while ($row = $result->fetch_assoc()) {
            $year = $row['Year'];
            $totalQuantitySold = $row['TotalQuantitySold'];
            $totalCost = $row['TotalCost'];
            $grossMargin = $row['SumOfGrossMargin'];

            // Create an associative array for each year's data
            $yearData = array(
                'Year' => $year,
                'TotalQuantitySold' => $totalQuantitySold,
                'TotalCost' => $totalCost,
                'GrossMargin' => $grossMargin
            );

            // Add the year's data to the 3D array
            $data[] = $yearData;
        }
    }

    // Close the database connection
    $conn->close();

    // Return the 3D array to the main program
    return $data;
}

function category_report($partNo , $category , $partDesc) {
	include 'sql.php';
	    // Construct the SQL query
    $query = "SELECT YEAR(s.Date) AS Year,
                     SUM(s.`Quantity Sold`) AS TotalQuantitySold,
                     SUM(s.Cost) AS TotalCost,
                     SUM(s.`Gross Margin`) AS SumOfGrossMargin
              FROM sales s
              WHERE s.Category = '$category'";

    if (!empty($partDesc)) {
      $query .= " AND s.`Part Desc` LIKE '%$partDesc%'";
    }

    if (!empty($partNo)) {
      $query .= " AND s.`Part No` LIKE '%$partNo%'";
    }

    $query .= " GROUP BY YEAR(s.Date)
                ORDER BY YEAR(s.Date)";

    // Execute the SQL query
    $result = $conn->query($query);

    // Initialize the 3D array for storing the data
    $data = array();

    if ($result->num_rows > 0) {
        // Fetch and store the data
        while ($row = $result->fetch_assoc()) {
            $year = $row['Year'];
            $totalQuantitySold = $row['TotalQuantitySold'];
            $totalCost = $row['TotalCost'];
            $grossMargin = $row['SumOfGrossMargin'];

            // Create an associative array for each year's data
            $yearData = array(
                'Year' => $year,
                'TotalQuantitySold' => $totalQuantitySold,
                'TotalCost' => $totalCost,
                'GrossMargin' => $grossMargin
            );

            // Add the year's data to the 3D array
            $data[] = $yearData;
        }
    }

    // Close the database connection
    $conn->close();

    // Return the 3D array to the main program
    return $data;
}
?>