<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Weather Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div id="content">
            <div id="table" class="visible">
                <h2>Live Weather Data</h2>
                <table>
                    <tr>
                        <th>Time</th>
                        <th>Temperature (°C)</th>
                        <th>Humidity (%)</th>
                    </tr>
                    <tbody id="data-table">
                        <!-- Data rows will be appended here -->
                    </tbody>
                </table>
            </div>
            <div id="chart" class="hidden">
                <h2>Temperature Over Time</h2>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <button id="switchBtn">Switch</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
    <script>
        async function fetchData() {
            const response = await fetch('/json');
            const data = await response.json();

            if (data.error) {
                console.error(data.error);
                return;
            }

            const tableBody = document.getElementById('data-table');
            tableBody.innerHTML = ''; // Clear existing rows

            const labels = [];
            const temperatures = [];
            const humidities = [];

            data.forEach(entry => {
                const { time, temperature, humidity } = entry;

                labels.push(time);
                temperatures.push(temperature);
                humidities.push(humidity);

                const tr = document.createElement('tr');
                const tdTime = document.createElement('td');
                const tdTemp = document.createElement('td');
                const tdHumidity = document.createElement('td');

                tdTime.textContent = time;
                tdTemp.textContent = temperature;
                tdHumidity.textContent = humidity;

                tr.appendChild(tdTime);
                tr.appendChild(tdTemp);
                tr.appendChild(tdHumidity);
                tableBody.appendChild(tr);
            });

            updateChart(labels, temperatures, humidities);
        }

        function updateChart(labels, temperatures, humidities) {
            const ctx = document.getElementById('lineChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Temperature (°C)',
                            data: temperatures,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: false
                        },
                        {
                            label: 'Humidity (%)',
                            data: humidities,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1,
                            fill: false
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Value'
                            }
                        }
                    }
                }
            });
        }

        setInterval(fetchData, 15000); // Fetch data every 15 seconds
        fetchData(); // Initial fetch
    </script>
</body>
</html>
