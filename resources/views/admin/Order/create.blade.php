{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Create Job Order')

@section('content_header')
<h1>Create Job Order</h1>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{asset('vendor/parsleyjs/src/parsley.css') }}">
    <link rel="stylesheet" href="{{asset('vendor/select2/css/select2.min.css') }}">
    <style>
        .car_image_div {
            width: 100%;
            text-align: center;
        }
        img[usemap] {
            border: none;
            height: auto;
            max-width: 100%;
            width: auto;
        }
        input[type=checkbox]{
            height:22px;
            width:22px;
        }
        .select2-selection{
            height: 38px !important;
        }
    </style>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{ Form::open(['id' => 'save_order', 'method' => 'post', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '']) }}

        {{ csrf_field() }}
        {{ Form::hidden('id', $order_data->id ?? '') }}
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('name', 'Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('name', $order_data->name ?? '', ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('mobile_no', 'Mobile', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('mobile_no', $order_data->mobile_no ?? '', ['id' => 'mobile', 'class' => 'form-control num_only', 'required' => 'required']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('order_date', 'Date', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('order_date', $order_data->order_date ?? date('d-m-Y'), ['id' => '', 'class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) }}
                </div>
            </div>
            <div class="col-md-3">
                @if(isset($order_data->order_time))
                <div class="form-group">
                    {{ Form::label('order_time', 'Time', ['class' => 'control-label']) }} <br>
                    {{ $order_data->order_time }}
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('car_id', 'Car', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control" id="car_id" name="car_id" required="required">
                        <option value=""> - Select Car - </option>
                        @forelse($cars as $car_key => $car_value)
                            <option value="<?php echo $car_value['id']; ?>" <?php echo (isset($order_data->car_id) && $order_data->car_id == $car_value['id']) ? 'Selected' : ''; ?> ><?php echo $car_value['car_name']; ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('car_model_id', 'Model', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control" id="car_model_id" name="car_model_id" required="required"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('model_year', 'Model Year', ['class' => 'control-label']) }}
                    {{ Form::text('model_year', $order_data->model_year ?? '', ['id' => 'model_year', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('mileage', 'Mileage', ['class' => 'control-label']) }}
                    {{ Form::text('mileage', $order_data->mileage ?? '', ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('receiver_id', 'Receiver Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control" id="receiver_id" name="receiver_id" required="required">
                        <option value=""> - Select User - </option>
                        @forelse($users as $user_key => $user_value)
                            <option value="<?php echo $user_value['id']; ?>" <?php echo (Auth::user()->id == $user_value['id']) ? 'Selected' : ''; ?> ><?php echo $user_value['first_name']; ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('expected_delivery_date', 'Expected Date of Delivery', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('expected_delivery_date', $order_data->expected_delivery_date ?? '', ['id' => 'expected_delivery_date', 'class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('price', 'Price', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('price', $order_data->price ?? '', ['class' => 'form-control num_only', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                {{ Form::label('', 'Tasks : ', ['class' => 'control-label']) }}
            </div>
            @forelse($tasks as $task_key => $task_value)
                <div class="col-md-4">
                    <div class="form-group">
                        <?php
                            $checkbox_value = '';
                            if(isset($order_data->checked_tasks) && in_array($task_value->id, $order_data->checked_tasks)) {
                                $checkbox_value = '[checked]';
                            }
                        ?>
                        {{ Form::checkbox('checked_tasks[]', $task_value->id, $checkbox_value, ['id' => 'task_id_' . $task_value->id]) }}
                        {{ Form::label('task_id_' . $task_value->id, $task_value->task_name, ['class' => 'control-label']) }}
                    </div>
                </div>
            @empty
            @endforelse
        </div>
        <hr>
        <div class="form-group">
            {{ Form::label('car_parts', 'Add Car Parts Details : ', ['class' => 'control-label']) }} <br>
            <div class="car_image_div">
                <img src="{{asset('images/car-tap-useme.png')}}" id="img_1" style="height:400px;" usemap="#car_job_parts" alt="" />
                <map name="car_job_parts">
                    <area alt="Front Bumper" title="Front Bumper" href="#frontbumper" coords="14,134,15,134,24,176,41,176,76,172,114,177,176,178,241,178,248,140,248,140,189,146,14,143,1,167,10,137" shape="poly">
                    <area alt="Rear Bumper" title="rear Bumper" href="#rearbumper" coords="16,367,19,394,33,411,84,405,151,405,187,405,235,414,247,367,227,366,183,364,221,366,230,367,223,363,227,366" shape="poly">
                    <area alt="Front Right Fender" title="Front Right Fender" href="#frontrightfender" coords="802,398,45" shape="circle">
                    <area alt="Front Left Fender" title="Front Left Fender" href="#frontleftfender" coords="430,155,45" shape="circle">
                    <area alt="Driver Door" title="Driver Door" href="#driverdoor" coords="584,311,589,395,740,396,731,315" shape="poly">
                    <area alt="Rear Left Door" title="Rear Left Door" href="#rearleftdoor" coords="644,69,639,150,734,152,767,101,759,65" shape="poly">
                    <area alt="Passenger Door" title="Passenger Door" href="#passengerdoor" coords="496,76,495,155,638,151,642,71" shape="poly">
                    <area alt="Rear Right Door" title="Rear Right Door" href="#rearrightdoor" coords="470,307,460,344,495,394,588,396,582,312" shape="poly">
                    <area alt="Rear Left Fender" title="Rear Left fender" href="#rearleftfender" coords="792,155,45" shape="circle">
                    <area alt="Rear Right Fender" title="Rear Right fender" href="#rearrightfender" coords="439,398,47" shape="circle">
                    <area alt="Trunk" title="Trunk" href="#trunk" coords="27,313,16,360,64,357,195,359,247,363,242,310" shape="poly">
                    <area alt="Hood" title="Hood" href="#hood" coords="31,74,14,118,81,122,175,124,219,122,246,122,236,75" shape="poly">
                    <area alt="Roof" title="Roof" href="#roof" coords="430,548,417,600,418,650,431,699,503,692,557,691,605,693,616,638,614,582,606,555" shape="poly">
                </map>
            </div>
        </div>
        {{ Form::submit('Save', ['class' => 'btn btn-primary module_save_btn']) }}
        {{ Form::submit('Save & Print', ['class' => 'btn btn-primary module_save_btn']) }}
        {{ Form::close() }}
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="AddPartTextModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="car_part_detail_id" id="car_part_detail_id">
            <input type="hidden" name="car_part_name" id="car_part_name">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('car_part_detail', 'Add Detail', ['class' => 'control-label']) }}
                    <textarea name="car_part_detail" id="car_part_detail" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    {{ Form::label('car_part_image', 'Upload Part Image', ['class' => 'control-label']) }}
                    <input type="file" name="car_part_image" id="car_part_image" >
                    <img id="car_part_image_tag" atr="car_part_image_tag" title="car_part_image_tag" style="width:100px; height:100px;">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="add_car_part_details" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="{{asset('vendor/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{asset('js/jquery.rwdImageMaps.min.js') }}"></script>
    <script src="{{asset('vendor/bootbox/bootbox.min.js') }}"></script>
    <script src="{{asset('vendor/parsleyjs/dist/parsley.js') }}"></script>
    <script src="{{asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        var car_part_details = {};
        <?php if (isset($order_data->car_part_details)) { ?>
            var li_car_part_details = JSON.parse('<?php echo $order_data->car_part_details; ?>');
            console.log(li_car_part_details);
            if (li_car_part_details != '') {
                $.each(li_car_part_details, function (index, value) {
                    var value_car_part_name = value.car_part_name;
                    car_part_details[value_car_part_name] = value;
                });
            }
        <?php } ?>
        $(document).ready( function(){
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                todayBtn: "linked",
                autoclose: true
            });
            $(document).on('input', ".num_only", function () {
                var textbox_value = this.value = this.value.replace(/[^\d\.\-]/g, '');
                var textbox_str = textbox_value.split(/\./);
                if(textbox_str.length > 2){
                    $(this).val('');
                }
            });

            $(document).on('change', "#car_id", function () {
                $('#car_model_id').val(null).trigger('change');
                var car_id = $('#car_id').val();
                $('#car_model_id').select2({
                    placeholder: "Choose Car Model...",
//                        minimumInputLength: 2,
//                        tags: true,
//                        multiple: true,
//                        maximumSelectionLength: 1,
                    ajax: {
                        url: "{{ URL::to('/admin/getModelsByCar/') }}",
                        dataType: 'json',
                        data: function (params) {
                            return {
                                car_id: car_id,
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
            });
            <?php if(isset($order_data->car_model_id) && !empty($order_data->car_model_id)){ ?>
                $('#car_id').change();
                var car_model_id = '{{ $order_data->car_model_id }}';
                $.ajax({
                    url: "{{ URL::to('/admin/setCarModel/') }}/" + car_model_id,
                    type: "GET",
                    data: null,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function (data) {
                        var selectValues = data;
                        $.each(selectValues, function(key, value) {
                            $('#car_model_id').select2("trigger", "select", {
                                data: value
                            });
                        });
                    }
                });
            <?php } ?>

            $('img[usemap]').rwdImageMaps();
            $('#car_part_image_tag').hide();
            $(document).on('click', 'area', function () {
                console.log(car_part_details);
                $('#AddPartTextModal').modal('show');
                $('.modal-title').html('For - ' + $(this).attr('alt'));
                var car_part_name = $(this).attr('href');
                var get_car_part_details = getObjects(car_part_details, 'car_part_name', car_part_name);
                if($.isEmptyObject(get_car_part_details)){
                    $('#car_part_name').val(car_part_name);
                    $('#car_part_image_tag').hide();
                } else {
                    $('#car_part_detail_id').val(car_part_details[car_part_name].car_part_detail_id);
                    $('#car_part_name').val(car_part_details[car_part_name].car_part_name);
                    $('#car_part_detail').val(car_part_details[car_part_name].car_part_detail);
                    if(car_part_details[car_part_name].car_part_image != null){
                        $('#car_part_image_tag').show();
                        $('#car_part_image_tag').attr('src', '{{ url("/uploads/car_part_image/") }}/' + car_part_details[car_part_name].car_part_image);
                        console.log('{{ url("/uploads/car_part_image/") }}/' + car_part_details[car_part_name].car_part_image);
                    }
                }
            });

            $('#AddPartTextModal').on('shown.bs.modal', function () {
                $('#car_part_detail').focus();
            });

            $('#AddPartTextModal').on('hidden.bs.modal', function () {
                $('#car_part_detail_id').val('');
                $('#car_part_name').val('');
                $('#car_part_detail').val('');
                $('#car_part_image').val('');
                $('#car_part_image_tag').hide();
            });
            $(document).on('click', '#add_car_part_details', function () {
                new_details = {};
                new_details['car_part_detail_id'] = $('#car_part_detail_id').val();
                var car_part_name = $('#car_part_name').val();
                new_details['car_part_name'] = $('#car_part_name').val();
                new_details['car_part_detail'] = $('#car_part_detail').val();
                new_details['car_part_image'] = $('#car_part_image').val();
                new_details['car_part_clicked'] = '1';
                car_part_details[car_part_name] = new_details;
                console.log(car_part_details);
                $('#AddPartTextModal').modal('hide');
                $('#save_order').submit();
                return false;
            });
            
            $('#save_order').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });

            $(document).on('submit', '#save_order', function(){
                var postData = new FormData(this);
                if($.isEmptyObject(car_part_details)){
                    bootbox.alert('<span class="text-danger">Add atleast one Car Part Details</span>');
                    return false;
                }
                console.log('car_part_details ');
                console.log(car_part_details); 
                var car_part_details_stringify = JSON.stringify(car_part_details);
//                console.log(car_part_details_stringify); return false;
                postData.append('car_part_details', car_part_details_stringify);
                postData.append('car_part_image', $('input[type=file]')[0].files[0]);
                $('.module_save_btn').attr('disabled', 'disabled');
                $.ajax({
                    url: "{{ URL::to('/admin/save_order') }}",
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
                            window.location.href =  json['order_id'] + "/edit";
                        } else if (json['success'] == 'Updated') {
                            bootbox.alert('<span class="text-success">Order Successfully Created</span>');
                            if (json['car_part_details']){
                                var li_car_part_details = JSON.parse(json['car_part_details']);
                                if (li_car_part_details != '') {
                                    $.each(li_car_part_details, function (index, value) {
                                        car_part_details[value.car_part_name] = value;
                                    });
                                }
                            }
                        } else {
                            bootbox.alert('<span class="text-danger">Something error occurred</span>');
                            return false;
                        }
                        return false;
                    },
                });
                return false;
            });
        });

        function getObjects(obj, key, val) {
            var objects = [];
            for (var i in obj) {
                if (!obj.hasOwnProperty(i)) continue;
                if (typeof obj[i] == 'object') {
                    objects = objects.concat(getObjects(obj[i], key, val));
                } else if (i == key && obj[key] == val) {
                    objects.push(obj);
                }
            }
            return objects;
        }
    </script>
@stop