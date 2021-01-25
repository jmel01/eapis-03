@extends('layouts.adminlte.template')

@section('title', 'Community Service Officer Dashboard')

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
                                <span class="info-box-text text-center text-muted">Estimated budget</span>
                                <span class="info-box-number text-center text-muted mb-0">2300</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Total amount spent</span>
                                <span class="info-box-number text-center text-muted mb-0">2000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Estimated project duration</span>
                                <span class="info-box-number text-center text-muted mb-0">20 <span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>

            </div>

            <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2 bg-light">

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
                        <iframe src="/community" style="display:block; min-height:600px; width:100%;" frameborder="0" marginwidth="0" marginheight="0" scrolling="yes" onload="" allowtransparency="false"></iframe>
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
                @foreach($barangays as $value)
                '{{$value->name}}',
                @endforeach
            ],
            datasets: [{
                    label: 'Grantee',
                    data: [89, 69, 73, 53, 85, 62, 83, 70, 84, 64, 63, 80, 82, 62, 54, 72, 87],

                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1

                }, {
                    label: 'Terminated',
                    data: [12, 19, 3, 5, 2, 3, 10, 4, 14, 3, 10, 22, 2, 4, 7, 12, 10],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132,1)',
                    borderWidth: 1

                }, {
                    label: 'Total Number of Applicant',
                    data: [100, 78, 85, 65, 92, 73, 90, 84, 94, 73, 70, 82, 92, 74, 67, 82, 90],
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
                text: 'Total Number of Applicant, Grantee and Termination of Scholarship Per Cities, Municipalities and Sub-Municipalities'
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
        type: 'polarArea',
        data: {
            labels: ['Failed to Submit Document', 'Failed Grade', 'DS', 'Not Enrolled', 'FPD', 'Enjoying Other Grants/Scholarship','Others'],
            datasets: [{
                label: '# of Votes',
                data: [2, 5, 3, 5, 2, 3,1],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)'
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