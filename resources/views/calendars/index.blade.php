@extends('layouts.adminlte.template')

@section('title', 'Announcement Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
<link rel="stylesheet" href="{{ asset('/css/full-calendar.css') }}">
<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<style>
    .fc-event-time,
    .fc-event-title {
        padding: 0 1px;
        white-space: nowrap;
    }

    .fc-title {
        white-space: normal;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Announcement</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        @can('announcement-add')
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="float-right">
                    <button type="button" class="btn btn-primary addCalendar">
                        Create New Announcement
                    </button>
                </div>
            </div>
        </div>
        @endcan
        <div class="row">
            <div class="col-md-7">
                <table id="calendarList" class="table table-sm table-hover table-responsive-lg">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $calendar)

                        <tr @if(date("Y-m-d")> $calendar->dateTimeEnd)class="text-danger"@endif>
                            <td>{{ date('d F Y', strtotime($calendar->dateTimeStart)) }}</td>
                            <td>{{ $calendar->title }}</td>
                            <td>{{ $calendar->description }}</td>
                            <td>
                                @can('announcement-edit')
                                <button data-url="{{ route('calendars.edit',$calendar->id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-calendar">Edit</button>
                                @endcan

                                @can('announcement-delete')
                                <button data-url="{{ route('calendars.destroy', $calendar->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-calendar">Delete</button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-5">
                <div id='calendar'></div>
            </div>
        </div>


    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@include('calendars.modalAnnouncement')
@include('calendars.modalShowAnnouncement')
@include('layouts.adminlte.modalDelete')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>


@if (count($errors->calendar) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalAnnouncement').modal('show');
    });
</script>
@endif

<script src="{{ asset('/bower_components/admin-lte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

<script>
    $(function() {
        //color picker with addon
        $('.my-colorpicker2').colorpicker()
        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });
        $('#calendarList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        $('.addCalendar').click(function() {
            document.getElementById("formCalendar").reset();
            $('[name="id"]').val('')
            $('[name="user_id"]').val('')
            $('#modalAnnouncement').modal('show')
        })

        $('.btn-edit-calendar').click(function() {
            var url_id = $(this).attr('data-url');
            $.get(url_id, function(data) {
                console.log(data)
              
                var dateFrom = new Date(data.announcement.dateTimeStart);
                    dateFrom.setMinutes(dateFrom.getMinutes() - dateFrom.getTimezoneOffset());
                var dateTo = new Date(data.announcement.dateTimeEnd);
                    dateTo.setMinutes(dateTo.getMinutes() - dateTo.getTimezoneOffset());

                $('[name="id"]').val(data.announcement.id)
                $('[name="user_id"]').val(data.announcement.user_id)
                $('[name="dateTimeStart"]').val(dateFrom.toISOString().slice(0,16))
                $('[name="dateTimeEnd"]').val(dateTo.toISOString().slice(0,16))
                
                $('[name="title"]').val(data.announcement.title)
                $('[name="description"]').val(data.announcement.description)
                $('[name="color"]').val(data.announcement.color)
                $('[name="region"]').val(data.announcement.region)

                $('#modalAnnouncement').modal('show')
            })
        })

        $('.btn-delete-calendar').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });
        
            function timestampToDatetimeInputString(timestamp) {
                const date = new Date((timestamp + _getTimeZoneOffsetInMs()));
                // slice(0, 19) includes seconds
                return date.toISOString().slice(0, 19);
            }
            
            function _getTimeZoneOffsetInMs() {
                return new Date().getTimezoneOffset() * -60 * 1000;
            }

    });
</script>

<script src="{{ asset('/js/full-calendar.js') }}"></script>
@include('calendars.scriptCalendar')
@endpush