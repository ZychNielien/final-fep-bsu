<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="averageRatingChart" width="400" height="200"></canvas>

<script>
    function fetchAverageRatings() {
        $.ajax({
            url: '.php', // Your PHP file to fetch data
            type: 'POST',
            data: {
                semester: $('#semesterSelect').val(), // Assuming you have a select for semester
                academic_year: $('#academicYearSelect').val() // Assuming you have a select for academic year
            },
            dataType: 'json',
            success: function (response) {
                if (response.subjects && response.averageRatings) {
                    updateChart(response.subjects, response.averageRatings);
                } else {
                    console.error('No data returned or invalid response format');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    }

    function updateChart(subjects, averageRatings) {
        const ctx = document.getElementById('averageRatingChart').getContext('2d');
        const averageRatingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: subjects,
                datasets: [{
                    label: 'Final Average Ratings',
                    data: averageRatings,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Average Rating'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Subjects'
                        }
                    }
                }
            }
        });
    }

    // Call the function on page load or specific events (like button click)
    $(document).ready(function () {
        fetchAverageRatings(); // Fetch and display data when the page loads

        // Optionally, you can call fetchAverageRatings() when the semester or academic year changes.
        $('#semesterSelect, #academicYearSelect').change(function () {
            fetchAverageRatings();
        });
    });
</script>