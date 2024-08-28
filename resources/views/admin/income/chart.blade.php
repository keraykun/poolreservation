<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js Example</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Create a canvas element for the chart -->
    <canvas id="myChart" width="600" height="400"></canvas>

    <script>
        // Sample data for daily, weekly, and monthly
        const dailyData = [10, 20, 15, 25, 30, 18, 22];
        const weeklyData = [50, 60, 55, 70, 65, 80, 75];
        const monthlyData = [150, 180, 200, 220, 250, 230, 210];

        // Get the canvas element
        const ctx = document.getElementById('myChart').getContext('2d');

        // Create a new chart
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
                datasets: [
                    {
                        label: 'Daily',
                        data: dailyData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Weekly',
                        data: weeklyData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Monthly',
                        data: monthlyData,
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
