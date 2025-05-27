fetch('grafik-zaman-veri.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('cizgi').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.tarih,
                datasets: [{
                    label: 'Günlük Arıza Kaydı',
                    data: data.sayi,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
