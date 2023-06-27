<?php
function generateLineChart($chartId, $labels, $data, $datasetLabel) {
  $color = generateRandomColors("1");
  $uniqueChartId = $chartId . "_" . uniqid(); // Append a unique identifier to the chart ID
  echo "<canvas id='$uniqueChartId'></canvas>";
  echo "<script>
          var ctx = document.getElementById('$uniqueChartId').getContext('2d');
          var $chartId = new Chart(ctx, {
            type: 'line',
            data: {
              labels: " . json_encode($labels) . ",
              datasets: [{
                label: '$datasetLabel',
                data: " . json_encode($data) . ",
                fill: false,
                backgroundColor: " . json_encode($color) . ",
                tension: 0.1
              }]
            },
            options: {
              responsive: true,
              scales: {
                x: {
                  display: true,
                  title: {
                    display: true,
                    text: 'Year'
                  }
                },
                y: {
                  display: true,
                  title: {
                    display: true,
                    text: '$datasetLabel'
                  }
                }
              }
            }
          });
        </script>";
}

function generatePieChart($chartId, $labels, $data, $datasetLabel) {
  $color = generateRandomColors(count($data));
  $uniqueChartId = $chartId . "_" . uniqid(); // Append a unique identifier to the chart ID
  echo "<canvas id='$uniqueChartId'></canvas>";
  echo "<script>
          var ctx = document.getElementById('$uniqueChartId').getContext('2d');
          var $chartId = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: " . json_encode($labels) . ",
              datasets: [{
                label: '$datasetLabel',
                data: " . json_encode($data) . ",
                fill: false,
                backgroundColor: " . json_encode($color) . ",
                tension: 0.1
              }]
            },
            options: {
              responsive: true,
              scales: {
                x: {
                  display: true,
                },
                y: {
                  display: true,
                }
              }
            }
          });
        </script>";
}

function generateBarChart($chartId, $labels, $data, $datasetLabel) {
  $uniqueChartId = $chartId . "_" . uniqid(); // Append a unique identifier to the chart ID
  echo "<canvas id='$uniqueChartId'></canvas>";
  echo "<script>
          var ctx = document.getElementById('$uniqueChartId').getContext('2d');
          var $chartId = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: " . json_encode($labels) . ",
              datasets: [{
                label: '$datasetLabel',
                data: " . json_encode($data) . ",
                fill: false,
                backgroundColor:  'rgba(214,214,161,0.7)',
				borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2,

                tension: 0.1
              }]
            },
            options: {
              responsive: true,
              scales: {
                x: {
                  display: true,
                },
                y: {
                  display: true,
                }
              }
            }
          });
        </script>";
}
function generateDoughnutChart($chartId, $labels, $data, $datasetLabel) {
  $uniqueChartId = $chartId . "_" . uniqid(); // Append a unique identifier to the chart ID
  $color = generateRandomColors(count($data));
  echo "<canvas id='$uniqueChartId'></canvas>";
  echo "<script>
          var ctx = document.getElementById('$uniqueChartId').getContext('2d');
          var $chartId = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: " . json_encode($labels) . ",
              datasets: [{
                label: '$datasetLabel',
                data: " . json_encode($data) . ",
                fill: false,
                backgroundColor:" . json_encode($color) . ",
                tension: 0.1
              }]
            },
            options: {
              responsive: true,
              scales: {
                x: {
                  display: true,
                },
                y: {
                  display: true,
                }
              }
            }
          });
        </script>";
}

function generateRandomColors($count) {
  $colors = [];

  for ($i = 0; $i < $count; $i++) {
    $color = "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ",0.7)";
    $colors[] = $color;
  }

  return $colors;
}
