{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Order List')

@section('content_header')
<h1>Order List</h1>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('vendor/datepicker/datepicker3.css') }}">
@stop


@section('content')
<div class="card">
    <div class="card-body">
        @if (Session::get('status') && Session::has('message'))
            <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
        @endif

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::label('car_id', 'Car', ['class' => 'control-label']) }}
                    <select class="form-control" id="car_id" name="car_id" required="required">
                        <option value=""> All </option>
                        @forelse($cars as $car_key => $car_value)
                            <option value="<?php echo $car_value['id']; ?>"><?php echo $car_value['car_name']; ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::label('mobile_no', 'Mobile', ['class' => 'control-label']) }}
                    <input type="text" id="mobile_no" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::label('from_date', 'From Date', ['class' => 'control-label']) }}
                    <input type="text" id="from_date" class="form-control datepicker" value="<?php echo date("d-m-Y", strtotime("first day of this month")); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::label('to_date', 'To Date', ['class' => 'control-label']) }}
                    <input type="text" id="to_date" class="form-control datepicker" value="<?php echo date('d-m-Y'); ?>">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="button" id="search_btn" class="btn btn-primary search_btn" value="Search">
                </div>
            </div>
        </div>

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

        <div class="modal fade" id="deleteOrderModel" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <form action="{{url('admin/orderDelete')}}" method="post" id="dform">
                        <div class="modal-body">
                            <p>Are you sure you want remove this Order?</p>
                            @csrf
                            <input type="hidden" name="delete_order_id" id="delete_order_id">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Yes</button>
                            <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>

@stop

@section('js')
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('vendor/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{asset('vendor/bootbox/bootbox.min.js') }}"></script>
    <script src="{{asset('js/comman.js') }}"></script>
    <script>
        var ordersTable;
        $(document).ready( function(){
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                todayBtn: "linked",
                autoclose: true
            });

            ordersTable = $('#dataTable-orders').DataTable({
                "bServerSide": true,
                "processing": true,
                "bRetrieve": true,
                "pageLength": 10,
                "ajax": {
                    "url": "{{ URL::to('/admin/getOrdersDatatable/') }}",
                    "type": "GET",
                    "data": function (d) {
                        d.car_id = $('#car_id').val();
                        d.mobile_no = $('#mobile_no').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    },
                },
                "columns": [{
                    "data": 'id',
                    "sClass": 'text-nowrap',
                    "render": function( data, type, full, meta ) {
                        var edit_button = '<a class="btn btn-sm btn-info edit-btn" href="order/' + data + '/edit"><i class="fa far fa-edit"></i></a>';
                        var delete_button = '';
                        var delete_button = '<button class="btn btn-sm btn-danger delete_order" title="Delete" onclick="DeleteModal('+ data +')"><span class="fa fa-times-circle"></span></button>';
                        var print_button = '<a class="btn btn-sm btn-info edit-btn" href="orderPrint/' + data + '" target="_blank"><i class="fa far fa-print"></i></a>';
                        return edit_button + ' ' + delete_button + ' ' + print_button;
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

            $(document).on('click', '#search_btn', function(){
                ordersTable.draw();
            });
        });

        function DeleteModal(delete_order_id) {
            $('#delete_order_id').val(delete_order_id);
            $('#deleteOrderModel').modal('show');
        }
    </script>
@stop
