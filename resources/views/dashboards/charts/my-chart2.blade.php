<canvas id="myChart2"></canvas>

<script>
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Regular EAP', 'Merit-based', 'PAMANA'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $numberOfEAP }}, {{ $numberOfMerit }}, {{ $numberOfPAMANA }}],

                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderColor: ['rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Number of Grantee per Type of Scholarship/Grant'
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });
</script>