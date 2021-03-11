<canvas id="myChart"></canvas>

@if($type == 'region')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($provinces as $value)
                    '{{$value->name}}',
                    @endforeach
                ],
                datasets: [ { 
                        label: 'New Applicant',
                        data: [ @foreach($provinces as $value)
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
                        data: [ @foreach($provinces as $value)
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
                        data: [ @foreach($provinces as $value)
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
                        data: [ @foreach($provinces as $value)
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
                        data: [ @foreach($provinces as $value)
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
                        data: [ @foreach($provinces as $value)
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
                    text: 'Total Number of Applicant, Grantee and Termination of Scholarship Per Region'
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
@elseif($type == 'province')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($cities as $value)
                '{{$value->name}}',
                @endforeach
            ],
            datasets: [ { 
                    label: 'New Applicant',
                    data: [ @foreach($cities as $value)
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
                    data: [ @foreach($cities as $value)
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
                    data: [ @foreach($cities as $value)
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
                    data: [ @foreach($cities as $value)
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
                    data: [ @foreach($cities as $value)
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
                    data: [ @foreach($cities as $value)
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
                text: 'Total Number of Applicant, Grantee and Termination of Scholarship Per Province'
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
@elseif($type == 'city')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($barangays as $value)
                '{{$value->name}}',
                @endforeach
            ],
            datasets: [ { 
                    label: 'New Applicant',
                    data: [ @foreach($barangays as $value)
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
                    data: [ @foreach($barangays as $value)
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
                    data: [ @foreach($barangays as $value)
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
                    data: [ @foreach($barangays as $value)
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
                    data: [ @foreach($barangays as $value)
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
                    data: [ @foreach($barangays as $value)
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
                text: 'Total Number of Applicant, Grantee and Termination of Scholarship Per City'
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
@endif
