@extends('layouts.adminlte.template')

@section('title', 'Provincial Officer Dashboard')

@push('style')
<link rel="stylesheet" href="{{ asset('/css/full-calendar.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Total Disbursement</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ $totalAdminCost + $totalGrantDisburse }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Total Adminitrative Cost</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ $totalAdminCost }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Total Grants Disbursement</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ $totalGrantDisburse }}<span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    <div class="card">
                            <div class="card-body">
                        <canvas id="myChart2"></canvas>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="card">
                            <div class="card-body">
                        <canvas id="myChart3"></canvas>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    <div class="card">
                            <div class="card-body">
                        <canvas id="myChart4"></canvas>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="card">
                            <div class="card-body">
                        <canvas id="myChart5"></canvas>
                        </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2 bg-light mb-3">

                <nav>
                    <div class="nav nav-tabs nav-fill" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#eventTab1" role="tab">
                            Events
                        </a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#messageTab2" role="tab">
                            Scholarship Community
                        </a>
                    </div>
                </nav>

                <div class="tab-content p-3" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="eventTab1" role="tabpanel">
                        <div id='calendar'></div>
                    </div>

                    <div class="tab-pane fade" id="messageTab2" role="tabpanel">
                        <iframe src="/community" style="display:block; min-height:700px; width:100%;" frameborder="0" marginwidth="0" marginheight="0" scrolling="yes" onload="" allowtransparency="false"></iframe>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

@include('layouts.adminlte.modalDelete')
@include('calendars.modalShowAnnouncement')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

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
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stacked: true
                    }
                }]
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Regular EAP', 'Merit-based', 'PAMANA'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $numberOfEAP }},
                {{ $numberOfMerit }}, 
                {{ $numberOfPAMANA }}
               ],

                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                    
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
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


<script>
var ctx = document.getElementById('myChart3').getContext('2d');
var myChart3 = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels:  ['Level'],
        datasets: [{
            label: 'Post Study',
            data: [{{ $numberOfPostStudy }}],
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)'],
            borderWidth: 1
        },{
            label: 'College',
            data: [{{ $numberOfCollege  }}],
            backgroundColor: ['rgba(54, 162, 235, 0.2)'],
            borderColor: ['rgba(54, 162, 235, 1)'],
            borderWidth: 1
        },{
            label: 'Vocational',
            data: [{{ $numberOfVocational  }}],
            backgroundColor: ['rgba(255, 206, 86, 0.2)'],
            borderColor: ['rgba(255, 206, 86, 1)'],
            borderWidth: 1
        },{
            label: 'High School',
            data: [{{ $numberOfHighSchool  }}],
            backgroundColor: ['rgba(75, 192, 192, 0.2)'],
            borderColor: ['rgba(75, 192, 192, 1)'],
            borderWidth: 1
        },{
            label: 'Elementary',
            data: [{{ $numberOfElementary }}],
            backgroundColor: ['rgba(153, 102, 255, 0.2)'],
            borderColor: ['rgba(153, 102, 255, 1)'],
            borderWidth: 1
        },
    ]
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

<script>
    var ctx = document.getElementById('myChart4').getContext('2d');
    var myChart4 = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Female', 'Male'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $numberOfFemales }},
                {{ $numberOfMales }}
               ],

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

<script>
    var ctx = document.getElementById('myChart5').getContext('2d');
    var myChart5 = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ['Terminated-FSD', 'Terminated-FG', 'Terminated-DS', 'Terminated-NE', 'Terminated-FPD', 'Terminated-EOGS','Terminated-Others'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $terminatedFSD }},
                {{ $terminatedFG }}, 
                {{ $terminatedDS }}, 
                {{ $terminatedNE }}, 
                {{ $terminatedFPD }},
                {{ $terminatedEOGS }},
                {{ $terminatedOthers }}],

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

<script src="{{ asset('/js/full-calendar.js') }}"></script>
@include('calendars.scriptCalendarApplicant')

@endpush