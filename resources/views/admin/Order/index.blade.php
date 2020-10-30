{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Order List')

@section('content_header')
<h1>Order List</h1>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
@stop


@section('content')
<div class="card">
    <div class="card-body">
        @if (Session::get('status') && Session::has('message'))
            <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
        @endif

        <div class="table-responsive">
            <table id="dataTable-orders" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-nowrap" width="100px">Action</th>
                        <th>Order No.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Car</th>
                        <th>Model</th>
                        <th>Model Year</th>
                        <th>Mileage</th>
                        <th>Receiver</th>
                        <th>Expected Delivery Date</th>
                        <th class="text-right">Price</th>
                        <th class="text-nowrap" width="100px">Created At</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('vendor/bootbox/bootbox.min.js') }}"></script>
    <script src="{{asset('js/comman.js') }}"></script>
    <script>
        var ordersTable;
        $(document).ready( function(){
            ordersTable = $('#dataTable-orders').DataTable({
                "bServerSide": true,
                "processing": true,
                "bRetrieve": true,
                "pageLength": 10,
                "ajax": {
                    "url": "{{ URL::to('/admin/getOrdersDatatable/') }}",
                    "type": "GET",
                    "data": function (d) {
//                        d.user_id = $('#user_id').val();
                    },
                },
                "columns": [{
                    "data": 'id',
                    "sClass": 'text-nowrap',
                    "render": function( data, type, full, meta ) {
                        var edit_button = '<a class="btn btn-sm btn-info edit-btn" href="order/' + data + '/edit"><i class="fa far fa-edit"></i></a>';
                        var delete_button = '';
//                        var delete_button = '<button class="btn btn-sm btn-danger delete_order" title="Delete" onclick="DeleteModal('+ data +')"><span class="fa fa-times-circle"></span></button>';
                        return edit_button + ' ' + delete_button;
                    }
                },{
                    "data": "id",
                    "defaultContent": '-',
                }, {
                    "data": "name",
                    "defaultContent": '-',
                    "searchable": false,
                }, {
                    "data": "mobile_no",
                    "defaultContent": '-',
                    "searchable": false,
                }, {
                    "data": "order_date_format",
                    "defaultContent": '-',
                    "searchable": false,
                    "sClass": 'text-nowrap',
                }, {
                    "data": "order_time_format",
                    "defaultContent": '-',
                    "sClass": 'text-nowrap',
                }, {
                    "data": "car_name",
                    "defaultContent": '-',
                }, {
                    "data": "model_name",
                    "defaultContent": '-',
                }, {
                    "data": "model_year",
                    "defaultContent": '-',
                }, {
                    "data": "mileage",
                    "defaultContent": '-',
                }, {
                    "data": "first_name",
                    "defaultContent": '-',
                }, {
                    "data": "expected_delivery_date_format",
                    "defaultContent": '-',
                    "sClass": 'text-nowrap',
                }, {
                    "data": "price",
                    "defaultContent": '-',
                }, {
                    "data": "created_at_format",
                    "defaultContent": '-',
                    "sClass": 'text-nowrap',
                    "searchable": false,
                }],
                "ordering": false,
                "searching": false,
            });

//            ordersTable.columns( [9] ).visible( false );

        });
    </script>
@stop
