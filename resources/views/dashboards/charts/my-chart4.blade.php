<canvas id="myChart4"></canvas>

<script>
    var ctx = document.getElementById('myChart4').getContext('2d');
    var myChart4 = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Female', 'Male'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $numberOfFemales }}, {{ $numberOfMales }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Number of Male/Female Grantee'
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });
</script>

