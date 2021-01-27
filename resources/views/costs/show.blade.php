@extends('layouts.adminlte.template')

@section('title', 'Admin Cost Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Admin Cost for SY {{$grant->acadYr}}-{{$grant->acadYr+1}} ({{$grant->region}})</h3>
    </div>
    <div class="card-body">

        <a href="/grants" class="btn btn-outline-primary btn-sm float-right mr-1">BACK</a>
        @can('expenses-edit')
        <button class="btn btn-outline-primary btn-sm btn-add-cost float-right mr-1">ADD ADMIN COST</button>
        @endcan

        <table id="costList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Date Received</th>
                    <th>Payee</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>Check No.</th>
                    <th>Province</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $cost)
                <tr>
                    <td>{{ $cost->dateRcvd }}</td>
                    <td>{{ $cost->payee }}</td>
                    <td>{{ $cost->particulars }}</td>
                    <td class="text-right">{{ number_format($cost->amount, 2, '.', ',') }}</td>
                    <td>{{ $cost->checkNo }}</td>
                    <td>{{ $cost->provname->name }}</td>

                    <td>
                    @can('expenses-edit')
                        <button data-url="{{ route('costs.edit',$cost->id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-cost">Edit</button>
                    @endcan
                    @can('expenses-edit')
                        <button data-url="{{ route('costs.destroy', $cost->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-cost">Delete</button>
                    @endcan

                    </td>
                </tr>
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

@include('costs.modalCost')
@include('layouts.adminlte.modalDelete')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#costList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(3, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(3).footer()).html(
                    'Total: ₱  ' + pageTotal.toLocaleString("en-US") + ' ( ₱ ' + total.toLocaleString("en-US") + ')'
                );
            },
        });

        $('.btn-add-cost').click(function() {
            document.getElementById("formCost").reset();
            $('#modalCost').modal('show')

        });

        $('.btn-edit-cost').click(function() {
            var url_id = $(this).attr('data-url');
            $.get(url_id, function(data) {
                console.log(data)
                $('[name="dateRcvd"]').val(data.cost.dateRcvd)
                $('[name="payee"]').val(data.cost.payee)
                $('[name="particulars"]').val(data.cost.particulars)
                $('[name="amount"]').val(data.cost.amount)
                $('[name="checkNo"]').val(data.cost.checkNo)
                $('[name="province"]').val(data.cost.province)
                $('[name="id"]').val(data.cost.id)
                $('[name="user_id"]').val(data.cost.user_id)

                $('#modalCost').modal('show')
            })
        })

        $('.btn-delete-cost').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });
    });
</script>

<!-- Error/Modal Opener -->
@if (count($errors->cost) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalCost').modal('show');
    });
</script>
@endif

@endpush