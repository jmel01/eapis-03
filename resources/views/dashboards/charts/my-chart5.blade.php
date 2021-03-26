<canvas id="myChart5"></canvas>

<script>
    var ctx = document.getElementById('myChart5').getContext('2d');
    var myChart5 = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ['Terminated-FSD', 'Terminated-FG', 'Terminated-DS', 'Terminated-NE', 'Terminated-FPD', 'Terminated-EOGS', 'Terminated-Others'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $terminatedFSD }},
                    {{ $terminatedFG }},
                    {{ $terminatedDS }},
                    {{ $terminatedNE }},
                    {{ $terminatedFPD }},
                    {{ $terminatedEOGS }},
                    {{ $terminatedOthers }}
                ],

                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Reason for Termination of Scholarship/Grant'
            },
            scale: {
                ticks: {
                    beginAtZero: true
                },
                reverse: false
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });
</script>