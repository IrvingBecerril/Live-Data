document.getElementById('switchBtn').addEventListener('click', function() {
    let table = document.getElementById('table');
    let chart = document.getElementById('chart');
    
    if (table.classList.contains('visible')) {
        table.classList.remove('visible');
        table.classList.add('hidden');
        chart.classList.remove('hidden');
        chart.classList.add('visible');
    } else {
        chart.classList.remove('visible');
        chart.classList.add('hidden');
        table.classList.remove('hidden');
        table.classList.add('visible');
    }
});

function drawChart(labels, temperatures, humidities) {
    var ctx = document.getElementById('lineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Temperature (�C)',
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
