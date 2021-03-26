<canvas id="myChart"></canvas>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($zone as $value)
                '{{$value->name}}',
                @endforeach
            ],
            datasets: [ { 
                    label: 'New Applicant',
                    data: [ @foreach($zone as $value)
                                @foreach($chartDataNew as $chartData)
                                    @if($chartData['code'] ==  $value->code)
                                        {{$chartData['count']}},
                                    @endif
                                @endforeach
                            @endforeach
                        ],

                    backgroundColor: 'rgba(106, 90, 205, 0.2)',
                    borderColor: 'rgba(106, 90, 205, 1)',
                    borderWidth: 1

                }, { 
                    label: 'On Process',
                    data: [ @foreach($zone as $value)
                                @foreach($chartDataOnProcess as $chartData)
                                    @if($chartData['code'] ==  $value->code)
                                        {{$chartData['count']}},
                                    @endif
                                @endforeach
                            @endforeach
                        ],

                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1

                }, { 
                    label: 'Grantee',
                    data: [ @foreach($zone as $value)
                                @foreach($chartDataApproved as $chartData)
                                    @if($chartData['code'] ==  $value->code)
                                        {{$chartData['count']}},
                                    @endif
                                @endforeach
                            @endforeach
                        ],

                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1

                }, {
                    label: 'Terminated',
                    data: [ @foreach($zone as $value)
                                @foreach($chartDataTerminated as $chartData)
                                    @if($chartData['code'] ==  $value->code)
                                        {{$chartData['count']}},
                                    @endif
                                @endforeach
                            @endforeach
                        ],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132,1)',
                    borderWidth: 1

                }, { 
                    label: 'Graduated',
                    data: [ @foreach($zone as $value)
                                @foreach($chartDataGraduated as $chartData)
                                    @if($chartData['code'] ==  $value->code)
                                        {{$chartData['count']}},
                                    @endif
                                @endforeach
                            @endforeach
                        ],

                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1

                }, {
                    label: 'Total Number of Applicant',
                    data: [ @foreach($zone as $value)
                                @foreach($chartDataAll as $chartData)
                                    @if($chartData['code'] ==  $value->code)
                                        {{$chartData['count']}},
                                    @endif
                                @endforeach
                            @endforeach
                        ],
                    type: 'line',
                    backgroundColor: 'rgba(244, 246, 249, 1)',
                    borderColor: 'rgba(52, 58, 64, 0.5)',
                    borderWidth: 1
                },

            ]
        },
        options: {

            title: {
                display: true,
                @if($type == 'region')
                text: 'Total Number of Applicant, Grantee and Termination of Scholarship Per Province/District'
                @elseif($type == 'province')
                text: 'Total Number of Applicant, Grantee and Termination of Scholarship Per City/Municipality'
                @elseif($type == 'city')
                text: 'Total Number of Applicant, Grantee and Termination of Scholarship Per Barangay'
                @endif
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            }
        }
    });
</script>