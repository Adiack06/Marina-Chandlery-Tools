<?php
$host = "127.0.0.1"; // host ip
$db_username = "root"; // mysql username
$db_password = 'root'; // mysql password
$db_name = "ayc"; // mysql database name e.g AR12345678

// Create connection
$conn = new mysqli($host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Run the SQL query
$sql = "SELECT
          YEAR(s.Date) AS Year,
          s.Category,
          SUM(s.`Gross Margin`) AS GrossMargin
        FROM
          sales s
        GROUP BY
          YEAR(s.Date),
          s.Category
        ORDER BY
          YEAR(s.Date),
          s.Category";

$result = $conn->query($sql);

// Fetch the data from the query result
$data = [];
while ($row = $result->fetch_assoc()) {
    $year = $row['Year'];
    $category = $row['Category'];
    $grossMargin = $row['GrossMargin'];

    $data[$year][$category] = $grossMargin;
}

// Prepare the data for JavaScript
$years = array_keys($data);
$categories = array_unique(array_column($data, 'Category'));
$graphData = [];

foreach ($years as $year) {
    $rowData = [];
    $rowData[] = $year;

    foreach ($categories as $category) {
        $rowData[] = isset($data[$year][$category]) ? $data[$year][$category] : 0;
    }

    $graphData[] = $rowData;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stacked Area Graph</title>
    <style>
        #chartContainer {
            width: 800px;
            height: 400px;
            margin: 0 auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.1/dist/apexcharts.min.js"></script>
</head>
<body>
    <div id="chartContainer"></div>

    <script>
        // Prepare the chart data
        var options = {
            chart: {
                type: 'area',
                stacked: true,
                height: 350,
                width: '100%',
            },
            series: [
                <?php
                $seriesData = [];

                foreach ($categories as $category) {
                    $seriesItem = [
                        'name' => $category,
                        'data' => [],
                    ];

                    foreach ($graphData as $rowData) {
                        $seriesItem['data'][] = $rowData[array_search($category, $categories) + 1];
                    }

                    $seriesData[] = $seriesItem;
                }

                echo json_encode($seriesData);
                ?>
            ],
            xaxis: {
                type: 'numeric',
                categories: <?php echo json_encode($years); ?>,
            },
        };

        // Render the chart
        var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
        chart.render();
    </script>
</body>
</html>