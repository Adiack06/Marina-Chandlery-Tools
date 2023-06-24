<?php
function item_report($partNo) {
	include 'sql.php';


	// Check the connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Construct the SQL query with a placeholder
	$query = "SELECT YEAR(s.Date) AS Year,
					 SUM(s.`Quantity Sold`) AS TotalQuantitySold,
					 SUM(s.Cost) AS TotalCost,
					 SUM(s.`Gross Margin`) AS GrossMargin
			 FROM sales s
			 WHERE s.`Part No` LIKE CONCAT('%', ?, '%')
			 GROUP BY YEAR(s.Date)
			 ORDER BY YEAR(s.Date)";

	// Prepare the statement
	$stmt = $conn->prepare($query);

	// Bind the sanitized input value
	$stmt->bind_param("s", $partNo);

	// Sanitize the input
	$partNo = $conn->real_escape_string($_POST['partNo']);

	// Execute the prepared statement
	$stmt->execute();

	// Get the result
	$result = $stmt->get_result();

	// Initialize the array for storing the data
	$data = [];


	// Close the prepared statement and database connection
	$stmt->close();
	$conn->close();
    if ($result->num_rows > 0) {
        // Fetch and store the data
        while ($row = $result->fetch_assoc()) {
            $year = $row['Year'];
            $totalQuantitySold = $row['TotalQuantitySold'];
            $totalCost = $row['TotalCost'];
            $grossMargin = $row['GrossMargin'];

            // Create an associative array for each year's data
            $yearData = array(
                'Year' => $year,
                'TotalQuantitySold' => $totalQuantitySold,
                'TotalCost' => $totalCost,
                'GrossMargin' => $grossMargin
            );

            // Add the year's data to the array
            $data[] = $yearData;
        }
    }

    // Return the array to the main program
    return $data;
}
function category_report($partNo, $category, $partDesc) {
    // Include the SQL connection script
    include 'sql.php';

    // Sanitize the input parameters
    $partNo = addslashes($partNo);
    $category = addslashes($category);
    $partDesc = addslashes($partDesc);

    // Construct the SQL query string
    $query = "SELECT YEAR(s.Date) AS Year,
                     SUM(s.`Quantity Sold`) AS TotalQuantitySold,
                     SUM(s.Cost) AS TotalCost,
                     SUM(s.`Gross Margin`) AS GrossMargin
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

    // Initialize the array for storing the data
    $data = [];

    // Fetch the result into the data array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $conn->close();

    if ($result->num_rows > 0) {
        // Add column names as the first "row" in the data array

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

    // Return the 3D array to the main program
    return $data;
}
function category_charged_report() {
	include 'sql.php';


	// Check the connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Construct the SQL query with a placeholder
	$query = "SELECT Category as 'index', COUNT('dates.idUniqueID') as 'boats', SUM(`boat info`.`Length (mtrs)`*(dates.`Date left`-`Date arrived`)) as 'meter days'
			FROM ayc.dates 
			LEFT JOIN `boat info` ON dates.ID = `boat info`.ID 
			WHERE `Date left` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
			GROUP BY Category 
			ORDER BY Category ASC;";

	// Prepare the statement
	$stmt = $conn->prepare($query);

	// Execute the prepared statement
	$stmt->execute();

	// Get the result
	$result = $stmt->get_result();

	// Initialize the array for storing the data
	$data = [];


	// Close the prepared statement and database connection
	$stmt->close();
	$conn->close();
    if ($result->num_rows > 0) {
        // Fetch and store the data
        while ($row = $result->fetch_assoc()) {
            $index = $row['index'];
            $boats = $row['boats'];
            $meter_days = $row['meter days'];

            // Create an associative array for each year's data
            $CategoryData = array(
                'index' => $index,
                'boats' => $boats,
                'meter_days' => $meter_days,
            );

            // Add the year's data to the array
            $data[] = $CategoryData;
        }
    }

    // Return the array to the main program
    return $data;
}

function copy_table($data) {
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

	echo "<button onclick='copyToClipboard()'>Copy Table Data</button>";

	$columnNames = array_keys($data[0]);

	// Create a table with the data
	echo "<h2>Table Data</h2>";
	echo "<table id='data-table'>
			<thead>
				<tr>";
	foreach ($columnNames as $columnName) {
		echo "<th>".$columnName."</th>";
	}
	echo "</tr>
		</thead>
		<tbody>";

	if (!empty($data)) {
		foreach ($data as $row) {
			echo "<tr>";
			foreach ($row as $value) {
				echo "<td>".$value."</td>";
			}
			echo "</tr>";
		}
	} else {
		echo "<tr>
				<td colspan='".count($columnNames)."'>No data found for the selected criteria.</td>
			</tr>";
	}

	echo "</tbody></table>";
}
?>