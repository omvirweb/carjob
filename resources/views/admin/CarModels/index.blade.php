{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Car Models')

@section('content_header')
<h1>Car Models</h1>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('vendor/parsleyjs/src/parsley.css') }}">
@stop


@section('content')
<div class="card">
    <div class="card-body">
        {{ Form::open(['id' => 'save_car_model', 'method' => 'post', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '']) }}
        {{ csrf_field() }}
        {{ Form::hidden('id', $car_data->id ?? '', ['id' => 'car_model_id']) }}
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('car_id', 'Car', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control" id="car_id" name="car_id" required="required">
                        <option value=""> - Select Car - </option>
                        @forelse($cars as $car_key => $car_value)
                            <option value="<?php echo $car_value['id']; ?>" ><?php echo $car_value['car_name']; ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('model_name', 'Car Model Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('model_name', $car_data->model_name ?? '', ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
            <div class="col-md-2">
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
                        <th>Model</th>
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
                    <form action="{{url('admin/carModelDelete')}}" method="post" id="dform">
                        <div class="modal-body">
                            <p>Are you sure you want remove this Car Model?</p>
                            @csrf
                            <input type="hidden" name="delete_car_model_id" id="delete_car_model_id">
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
            
            $(document).on('submit', '#save_car_model', function(){
                var postData = new FormData(this);
                $('.module_save_btn').attr('disabled', 'disabled');
                $.ajax({
                    url: "{{ URL::to('/admin/save_car_model') }}",
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
                            $('#car_id').val(null).trigger('change');
                            $('#model_name').val('');
                            carsTable.draw();
                            bootbox.alert('<span class="text-success">Car Model Successfully Created</span>');
                        } else if (json['success'] == 'Updated') {
                            $('#car_id').val(null).trigger('change');
                            $('#model_name').val('');
                            carsTable.draw();
                            bootbox.alert('<span class="text-success">Car Model Successfully Updated</span>');
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

            $(document).on('click', '.edit_car_model', function(){
                var car_model_id = $(this).attr('data-car_model_id');
                $.ajax({
                    url: "car-models/" + car_model_id + "/edit",
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
                        $('#car_model_id').val(json['car_model_data'].id);
                        $('#car_id').val(json['car_model_data'].car_id).trigger('change');
                        $('#model_name').val(json['car_model_data'].model_name);
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
                    "url": "{{ URL::to('/admin/getCarModelsDatatable/') }}",
                    "type": "GET",
                    "data": function (d) {
//                        d.car_id = $('#car_id').val();
                    },
                },
                "columns": [{
                    "data": 'id',
                    "sClass": 'text-nowrap',
                    "render": function( data, type, full, meta ) {
                        var edit_button = '<button class="btn btn-sm btn-info edit_car_model" data-car_model_id="'+ data +'"><i class="fa far fa-edit"></i></button>';
                        var delete_button = '<button class="btn btn-sm btn-danger delete_car_model" title="Delete" onclick="DeleteModal('+ data +')"><span class="fa fa-times-circle"></span></button>';
                        return edit_button + ' ' + delete_button;
                    }
                }, {
                    "data": "car_name",
                    "defaultContent": '-',
                    "searchable": false,
                }, {
                    "data": "model_name",
                    "defaultContent": '-',
                    "searchable": false,
                }],
                "ordering": false,
                "searching": false,
            });
        });

        function DeleteModal(delete_car_model_id) {
            $('#delete_car_model_id').val(delete_car_model_id);
            $('#deleteCarModel').modal('show');
        }
    </script>
@stop
