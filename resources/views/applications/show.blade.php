@extends('layouts.adminlte.template')

@section('title', 'Applications Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Applications for SY {{$grant->acadYr}}-{{$grant->acadYr+1}} ({{$grant->psgCode->name}})
        </h3>
    </div>
    <div class="card-body">

        <a href="/grants" class="btn btn-outline-primary btn-sm float-right mr-1">BACK</a>

        <table id="applicationList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Batch</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Province</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $application)
                @hasanyrole('Admin|Executive Officer')
                <tr>
                    <td>{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }}
                        {{ ucwords(substr($application->applicant->middleName,1,'1')) }}.
                    </td>
                    <td>{{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1 }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ $application->level }}</td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->remarks }}</td>
                    @php
                    $provinceId = Str::substr($application->applicant->psgcBrgy->code, 0, 4).'00000';
                    $psgcProvince = App\Models\Psgc::where([['code', '=' , $provinceId ], ['level', 'Prov']])->first();
                    @endphp

                    <td>{{ $psgcProvince->name ?? '' }}</td>

                    <td>
                        @can('application-edit')
                        <button data-url="{{ route('applications.edit',$application->id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-application">Edit</button>
                        @endcan
                        @can('application-delete')
                        <button data-url="{{ route('applications.destroy', $application->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-application">Delete</button>
                        @endcan

                        <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm mr-1">Files</a>

                        @can('expenses-add')
                        @if($application->status=='Approved')
                        <button data-payee="{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }} {{ ucwords(substr($application->applicant->middleName,1,'1')) }}." data-particular="Grant Payment" data-province="{{ $provinceId }}" data-userId="{{ $application->user_id }}" data-applicationId="{{ $application->id }}" class="btn btn-success btn-sm mr-1 btn-add-cost">Payment</button>
                        @endif
                        @endcan

                        @if($application->status=='Graduated')
                        @if(App\Models\Employment::where('user_id',$application->user_id )->count() > 0)
                        <button data-userID="{{ $application->employment->user_id }}" data-yearEmployed="{{ $application->employment->yearEmployed }}" data-employerType="{{ $application->employment->employerType }}" data-position="{{ $application->employment->position }}" data-employerName="{{ $application->employment->employerName }}" data-employerAddress="{{ $application->employment->employerAddress }}" class="btn btn-primary btn-sm mr-1 btn-add-employment">Employed</button>
                        @else
                        <button data-userID="{{ $application->user_id }}" class="btn btn-warning btn-sm mr-1 btn-add-employment">Employment</button>
                        @endif
                        @endif
                    </td>
                </tr>
                @endhasanyrole

                @hasanyrole('Regional Officer')
                @if(substr($application->applicant->psgcBrgy->code, 0, 2) == $locationId)
                <tr>
                    <td>{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }}
                        {{ ucwords(substr($application->applicant->middleName,1,'1')) }}.
                    </td>
                    <td>{{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1 }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ $application->level }}</td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->remarks }}</td>
                    @php
                    $provinceId = Str::substr($application->applicant->psgcBrgy->code, 0, 4).'00000';
                    $psgcProvince = App\Models\Psgc::where([['code', '=' , $provinceId ], ['level', 'Prov']])->first();
                    @endphp

                    <td>{{ $psgcProvince->name ?? '' }}</td>

                    <td>
                        @can('application-edit')
                        <button data-url="{{ route('applications.edit',$application->id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-application">Edit</button>
                        @endcan
                        @can('application-delete')
                        <button data-url="{{ route('applications.destroy', $application->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-application">Delete</button>
                        @endcan

                        <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm mr-1">Files</a>

                        @can('expenses-add')
                        @if($application->status=='Approved')
                        <button data-payee="{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }} {{ ucwords(substr($application->applicant->middleName,1,'1')) }}." data-particular="Grant Payment" data-province="{{ $provinceId }}" data-userId="{{ $application->user_id }}" data-applicationId="{{ $application->id }}" class="btn btn-success btn-sm mr-1 btn-add-cost">Payment</button>
                        @endif
                        @endcan

                        @if($application->status=='Graduated')
                        @if(App\Models\Employment::where('user_id',$application->user_id )->count() > 0)
                        <button data-userID="{{ $application->employment->user_id }}" data-yearEmployed="{{ $application->employment->yearEmployed }}" data-employerType="{{ $application->employment->employerType }}" data-position="{{ $application->employment->position }}" data-employerName="{{ $application->employment->employerName }}" data-employerAddress="{{ $application->employment->employerAddress }}" class="btn btn-primary btn-sm mr-1 btn-add-employment">Employed</button>
                        @else
                        <button data-userID="{{ $application->user_id }}" class="btn btn-warning btn-sm mr-1 btn-add-employment">Employment</button>
                        @endif
                        @endif
                    </td>
                </tr>
                @endif
                @endhasanyrole

                @hasanyrole('Provincial Officer|Community Service Officer')
                @if(substr($application->applicant->psgcBrgy->code, 0, 4) == $locationId)
                <tr>
                    <td>{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }}
                        {{ ucwords(substr($application->applicant->middleName,1,'1')) }}.
                    </td>
                    <td>{{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1 }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ $application->level }}</td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->remarks }}</td>
                    @php
                    $provinceId = Str::substr($application->applicant->psgcBrgy->code, 0, 4).'00000';
                    $psgcProvince = App\Models\Psgc::where([['code', '=' , $provinceId ], ['level', 'Prov']])->first();
                    @endphp

                    <td>{{ $psgcProvince->name ?? '' }}</td>

                    <td>
                        @can('application-edit')
                        <button data-url="{{ route('applications.edit',$application->id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-application">Edit</button>
                        @endcan
                        @can('application-delete')
                        <button data-url="{{ route('applications.destroy', $application->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-application">Delete</button>
                        @endcan

                        <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm mr-1">Files</a>

                        @can('expenses-add')
                        @if($application->status=='Approved')
                        <button data-payee="{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }} {{ ucwords(substr($application->applicant->middleName,1,'1')) }}." data-particular="Grant Payment" data-province="{{ $provinceId }}" data-userId="{{ $application->user_id }}" data-applicationId="{{ $application->id }}" class="btn btn-success btn-sm mr-1 btn-add-cost">Payment</button>
                        @endif
                        @endcan

                        @if($application->status=='Graduated')
                        @if(App\Models\Employment::where('user_id',$application->user_id )->count() > 0)
                        <button data-userID="{{ $application->employment->user_id }}" data-yearEmployed="{{ $application->employment->yearEmployed }}" data-employerType="{{ $application->employment->employerType }}" data-position="{{ $application->employment->position }}" data-employerName="{{ $application->employment->employerName }}" data-employerAddress="{{ $application->employment->employerAddress }}" class="btn btn-primary btn-sm mr-1 btn-add-employment">Employed</button>
                        @else
                        <button data-userID="{{ $application->user_id }}" class="btn btn-warning btn-sm mr-1 btn-add-employment">Employment</button>
                        @endif
                        @endif
                    </td>
                </tr>
                @endif
                @endhasanyrole

                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-right"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
    <div class="card-footer">
        Footer
    </div>
</div>

@include('applications.modalApplication')
@include('applications.modalApplicationEdit')
@include('costs.modalCost')
@include('employment.modalEmployment')
@include('layouts.adminlte.modalDelete')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js">
</script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#applicationList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searchi    ng": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        $('.btn-add-cost').click(function() {
            document.getElementById("formCost").reset();
            $('#modalCost').modal('show')
            var payee = $(this).attr('data-payee');
            var particular = $(this).attr('data-particular');
            var province = $(this).attr('data-province');
            var userId = $(this).attr('data-userId');
            var applicationId = $(this).attr('data-applicationId');

            $('[name="payee"]').val(payee)
            $('[name="particulars"]').val(particular)
            $('[name="province"]').val(province)
            $('[name="user_id"]').val(userId)
            $('[name="application_id"]').val(applicationId)
        });

        $('.btn-add-employment').click(function() {
            document.getElementById("formEmployment").reset();
            $('#modalEmployment').modal('show')
            var userID = $(this).attr('data-userID');
            var yearEmployed = $(this).attr('data-yearEmployed');
            var employerType = $(this).attr('data-employerType');
            var position = $(this).attr('data-position');
            var employerName = $(this).attr('data-employerName');
            var employerAddress = $(this).attr('data-employerAddress');

            $('[name="user_id"]').val(userID)
            $('[name="yearEmployed"]').val(yearEmployed)
            $('[name="employerType"]').val(employerType)
            $('[name="position"]').val(position)
            $('[name="employerName"]').val(employerName)
            $('[name="employerAddress"]').val(employerAddress)
        });

        $('.btn-add-application').click(function() {
            document.getElementById("formApplication").reset();
            $('#modalApplication').modal('show')
        });

        $('.btn-edit-application').click(function() {
            var url_id = $(this).attr('data-url');
            $.get(url_id, function(data) {
                console.log(data)
                $('[name="type"]').val(data.application.type)
                $('[name="level"]').val(data.application.level)
                $('[name="school"]').val(data.application.school)
                $('[name="course"]').val(data.application.course)
                $('[name="contribution"]').val(data.application.contribution)
                $('[name="plans"]').val(data.application.plans)
                $('[name="status"]').val(data.application.status)
                $('[name="remarks"]').val(data.application.remarks)
                $('[name="user_id"]').val(data.application.user_id)
                $('[name="grant_id"]').val(data.application.grant_id)
                $('[name="id"]').val(data.application.id)

                $('#modalApplicationEdit').modal('show')
            })
        })

        $('.btn-delete-application').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });
    });
</script>

<!-- Error/Modal Opener -->
@if (count($errors->application) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalApplication').modal('show');
    });
</script>
@endif

@if (count($errors->employment) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalEmployment').modal('show');
    });
</script>
@endif

@endpush