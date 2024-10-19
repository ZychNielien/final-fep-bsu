<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h5 id="semester"></h5>
    <h5 id="academicYear"></h5>

    <div style="max-height: 500px; max-width: 500px;">
        <canvas id="averageRatingChart" max-width="500" max-height="500"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: 'peerToPeerGraph.php',
                type: 'GET',
                dataType: 'json',
                success: function (categoriesData) {
                    const peerToPeerctx = document.getElementById('averageRatingChart').getContext('2d');
                    const chart = new Chart(peerToPeerctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(categoriesData), // Category names
                            datasets: [{
                                label: 'Average Ratings',
                                data: Object.values(categoriesData), // Average ratings
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 5, // Set max to 5
                                    title: {
                                        display: true,
                                        text: 'Average Rating'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Categories'
                                    }
                                }
                            },
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                            }
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        });
    </script>
</body>