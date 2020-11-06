{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Cars')

@section('content_header')
<h1>Cars</h1>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('vendor/parsleyjs/src/parsley.css') }}">
@stop


@section('content')
<div class="card">
    <div class="card-body">
        {{ Form::open(['id' => 'save_car', 'method' => 'post', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '']) }}
        {{ csrf_field() }}
        {{ Form::hidden('id', $car_data->id ?? '', ['id' => 'car_id']) }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('car_name', 'Car Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('car_name', $car_data->car_name ?? '', ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
            <div class="col-md-6">
                <label>&nbsp;</label><br>
                {{ Form::submit('Save', ['class' => 'btn btn-primary module_save_btn']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<div class="card">
    <div class="card-body">
        @if (Session::get('status') && Session::has('message'))
            <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
        @endif

        <div class="table-responsive">
            <table id="dataTable-cars" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-nowrap" width="100px">Action</th>
                        <th>Car</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="deleteCarModel" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <form action="{{url('admin/carDelete')}}" method="post" id="dform">
                        <div class="modal-body">
                            <p>Are you sure you want remove this Car?</p>
                            @csrf
                            <input type="hidden" name="delete_car_id" id="delete_car_id">
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
    <script src="{{asset('vendor/parsleyjs/dist/parsley.js') }}"></script>
    <script src="{{asset('vendor/bootbox/bootbox.min.js') }}"></script>
    <script src="{{asset('js/comman.js') }}"></script>
    <script>
        var carsTable;
        $(document).ready( function(){
            
            $(document).on('submit', '#save_car', function(){
                var postData = new FormData(this);
                $('.module_save_btn').attr('disabled', 'disabled');
                $.ajax({
                    url: "{{ URL::to('/admin/save_car') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: postData,
                    datatype: 'json',
                    async: false,
                    success: function (response) {
                        $('.module_save_btn').removeAttr('disabled', 'disabled');
                        var json = $.parseJSON(response);
                        if (json['success'] == 'Added') {
                            $('#car_name').val('');
                            carsTable.draw();
                            bootbox.alert('<span class="text-success">Car Successfully Created</span>');
                        } else if (json['success'] == 'Updated') {
                            $('#car_name').val('');
                            carsTable.draw();
                            bootbox.alert('<span class="text-success">Car Successfully Updated</span>');
                            $('.module_save_btn').val('Save');
                        } else {
                            bootbox.alert('<span class="text-danger">Something error occurred</span>');
                            return false;
                        }
                        return false;
                    },
                });
                return false;
            });

            $(document).on('click', '.edit_car', function(){
                var car_id = $(this).attr('data-car_id');
                $.ajax({
                    url: "cars/" + car_id + "/edit",
                    type: "GET",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: {},
                    datatype: 'json',
                    async: false,
                    success: function (response) {
                        $('.module_save_btn').removeAttr('disabled', 'disabled');
                        var json = $.parseJSON(response);
                        $('#car_id').val(json['car_data'].id);
                        $('#car_name').val(json['car_data'].car_name);
                        $('.module_save_btn').val('Update');
                        return false;
                    },
                });
                return false;
            });

            carsTable = $('#dataTable-cars').DataTable({
                "bServerSide": true,
                "processing": true,
                "bRetrieve": true,
                "pageLength": 10,
                "ajax": {
                    "url": "{{ URL::to('/admin/getCarsDatatable/') }}",
                    "type": "GET",
                    "data": function (d) {
//                        d.car_id = $('#car_id').val();
                    },
                },
                "columns": [{
                    "data": 'id',
                    "sClass": 'text-nowrap',
                    "render": function( data, type, full, meta ) {
                        var edit_button = '<button class="btn btn-sm btn-info edit_car" data-car_id="'+ data +'"><i class="fa far fa-edit"></i></button>';
                        var delete_button = '<button class="btn btn-sm btn-danger delete_car" title="Delete" onclick="DeleteModal('+ data +')"><span class="fa fa-times-circle"></span></button>';
                        return edit_button + ' ' + delete_button;
                    }
                }, {
                    "data": "car_name",
                    "defaultContent": '-',
                    "searchable": false,
                }],
                "ordering": false,
                "searching": false,
            });
        });

        function DeleteModal(delete_car_id) {
            $('#delete_car_id').val(delete_car_id);
            $('#deleteCarModel').modal('show');
        }
    </script>
@stop
