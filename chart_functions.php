<?php
function generateLineChart($chartId, $labels, $data, $datasetLabel) {
  $color = generateRandomColors("1");
  echo "<canvas id='$chartId'></canvas>";
  echo "<script>
          var ctx = document.getElementById('$chartId').getContext('2d');
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

function generatePieChart($chartId, $labels, $data, $chartTitle) {
  $colors = generateRandomColors(count($labels));

  echo "<canvas id='$chartId'></canvas>";
  echo "<script>
          var ctx = document.getElementById('$chartId').getContext('2d');
          var $chartId = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: " . json_encode($labels) . ",
              datasets: [{
                label: '$chartTitle',
                data: " . json_encode($data) . ",
                backgroundColor: " . json_encode($colors) . ",
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              plugins: {
                title: {
                  display: true,
                  text: '$chartTitle'
                }
              }
            }
          });
        </script>";
}

function generateRandomColors($count) {
  $colors = [];

  for ($i = 0; $i < $count; $i++) {
    $color = "rgb(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ")";
    $colors[] = $color;
  }

  return $colors;
}
