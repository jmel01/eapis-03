<canvas id="myChart3"></canvas>

<script>
    var ctx = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: ['Level'],
            datasets: [{
                label: 'Post Study',
                data: [{{ $numberOfPostStudy }}],
                backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }, {
                label: 'College',
                data: [{{ $numberOfCollege }}],
                backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }, {
                label: 'Vocational',
                data: [{{ $numberOfVocational }}],
                backgroundColor: ['rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }, {
                label: 'High School',
                data: [{{ $numberOfHighSchool }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }, {
                label: 'Elementary',
                data: [{{ $numberOfElementary }}],
                backgroundColor: ['rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }, ]
        },
        options: {
            title: {
                display: true,
                text: 'Total Number of Grantee per Level of Scholarship/Grant'
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>