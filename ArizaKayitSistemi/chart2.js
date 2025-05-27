fetch('grafik-durum-veri.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('pasta-chart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Arıza Durumları',
                    data: data.counts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',     // Çözüldü
                        'rgba(255, 206, 86, 0.2)',     // Beklemede
                        'rgba(54, 162, 235, 0.2)',     // İşlemde
                        'rgba(75, 192, 192, 0.2)'      // Yönlendirildi
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    });
