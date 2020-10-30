{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Create Job Order')

@section('content_header')
<h1>Create Job Order</h1>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor/datepicker/datepicker3.css') }}">
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
        {{ Form::open(['id' => 'save_order_details', 'enctype' => 'multipart/form-data']) }}

        {{ csrf_field() }}
        {{ Form::hidden('id', $item_details_data->id ?? '') }}
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('name', 'Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('name', $item_details_data->name ?? '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('date', 'Date', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('date', $item_details_data->date ?? date('d-m-Y'), ['id' => '', 'class' => 'form-control datepicker']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('time', 'Time', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::time('time', $item_details_data->time ?? Carbon\Carbon::now()->format('H:i'), ['id' => '', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('mobile', 'Mobile', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('mobile', $item_details_data->mobile ?? '', ['id' => 'mobile', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('receiver_id', 'Receiver Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control" id="receiver_id" name="receiver_id">
                        <option value=""> - Select User - </option>
                        @forelse($users as $user_key => $user_value)
                            <option value="<?php echo $user_value['id']; ?>" <?php echo (Auth::user()->id == $user_value['id']) ? 'Selected' : ''; ?> ><?php echo $user_value['first_name']; ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('carid', 'Car', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control" id="car_id" name="car_id">
                        <option value=""> - Select Car - </option>
                        @forelse($cars as $car_key => $car_value)
                            <option value="<?php echo $car_value['id']; ?>" ><?php echo $car_value['car_name']; ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('modelid', 'Model', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control" id="car_model_id" name="car_model_id">
                        <option value=""> - Select Car Model - </option>
                        @forelse($carmodels as $car_model_key => $car_model_value)
                            <option value="<?php echo $car_model_value['id']; ?>" ><?php echo $car_model_value['model_name']; ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('model_year', 'Model Year', ['class' => 'control-label']) }}
                    {{ Form::text('model_year', $item_details_data->model_year ?? '', ['id' => 'model_year', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('mileage', 'Mileage', ['class' => 'control-label']) }}
                    {{ Form::text('mileage', $item_details_data->mileage ?? '', ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('ex_delivery_date', 'Expected Date of Delivery', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('ex_delivery_date', $item_details_data->ex_delivery_date ?? '', ['id' => 'ex_delivery_date', 'class' => 'form-control datepicker']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('price', 'Price', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('price', $item_details_data->price ?? '', ['class' => 'form-control num_only']) }}
                </div>
            </div>
        </div>
        <div class="car_image_div">
            <img src="{{asset('images/car-tap-4.jpg')}}" id="img_1" style="height:400px;" usemap="#car_job_parts" alt="" />
            <map name="car_job_parts">
                <area alt="Left First Wheel" title="Left First Wheel" href="#LeftFirstWheel" coords="45,206,38" shape="circle">
                <area alt="Car Bonate" title="Car Bonate" href="#CarBonate" coords="165,132,161,168,158,207,157,231,155,249,168,241,181,236,193,230,206,228,220,226,238,225,252,225,267,226,279,226,292,227,301,228,313,229,323,232,335,237,347,241,362,246,367,251,368,243,367,231,366,219,366,206,366,193,366,180,364,163,363,153,363,142,359,128,340,121,319,119,293,115,268,115,242,117,224,116,204,117,191,120,179,124" shape="poly">
                <area alt="Right First Wheel" title="Right First Wheel" href="#RightFirstWheel" coords="479,206,38" shape="circle">
            </map>
        </div>
        {{ Form::button('Save', ['class' => 'btn btn-primary module_save_btn disabled'], 'disabled') }}
        <!--{{ Form::submit('Save', ['class' => 'btn btn-primary module_save_btn disabled'], 'disabled') }}-->
        
        {{ Form::close() }}
        <br><br><hr>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('photo', 'Photo', ['class' => 'control-label']) }}
                    {{ Form::file('photo', []) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'wheels off service', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'wheel polishing', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'interior trim polishing', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'multi stage paint correction', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'single step polish', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'leather coating', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', '1 year ceramic coating', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'light interior cleaning', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'medium duty interior', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', '2 year ceramic coating', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'headlight restoration', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'engine bay detailing', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', '3 year ceramic coating', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'windshield protection film', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'high IR rejection window tinting', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'fabric coating', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'paintless dent removal', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'cement & tar removal', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'heavy duty interior cleaning', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'paint protection film', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'ppf front quarter', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'windshield coating', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'ppf full body', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'ppf for headlights only', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'touch up paint', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'nano ceramic visit 2', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'orange peel removal', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'window tint removal', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '') }}
                    {{ Form::label('', 'ppf full front', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::checkbox('', '1', $item_details_data->item_available ?? '[checked]') }}
                    {{ Form::label('', 'nano ceramic maintenance visit 1', ['class' => 'control-label']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('hood', 'Hood', ['class' => 'control-label']) }}
                    {{ Form::file('hood', []) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('roof', 'Roof', ['class' => 'control-label']) }}
                    {{ Form::file('roof', []) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('door_1', 'Door 1', ['class' => 'control-label']) }}
                    {{ Form::file('door_1', []) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('door_2', 'Door 2', ['class' => 'control-label']) }}
                    {{ Form::file('door_2', []) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('door_3', 'Door 3', ['class' => 'control-label']) }}
                    {{ Form::file('door_3', []) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('door_4', 'Door 4', ['class' => 'control-label']) }}
                    {{ Form::file('door_4', []) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('trunk', 'Trunk', ['class' => 'control-label']) }}
                    {{ Form::file('trunk', []) }}
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="AddPartTextModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="post" id="add_car_part_details">
                <input type="hidden" name="car_part_name" id="car_part_name">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <label for="car_part_detail">Add Detail :</label>
                    <textarea name="car_part_detail" id="car_part_detail" class="form-control"></textarea>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="{{asset('vendor/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{asset('js/jquery.rwdImageMaps.min.js') }}"></script>
    <script>
        var car_part_details = {};
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
            
            $('img[usemap]').rwdImageMaps();
            $(document).on('click', 'area', function () {
                $('#AddPartTextModal').modal('show');
                $('.modal-title').html('Add Details for - ' + $(this).attr('alt'));
                var car_part_name = $(this).attr('href');
                $('#car_part_name').val(car_part_name);
                if(car_part_details[car_part_name]){
                    var car_part_detail = car_part_details[car_part_name];
                    $('#car_part_detail').val(car_part_detail);
                }
            });

            $('#AddPartTextModal').on('shown.bs.modal', function () {
                $('#car_part_detail').focus();
            });

            $('#AddPartTextModal').on('hidden.bs.modal', function () {
                $('#car_part_name').val('');
                $('#car_part_detail').val('');
            });
            $(document).on('submit', '#add_car_part_details', function () {
                var car_part_name = $('#car_part_name').val();
                car_part_details[car_part_name] = $('#car_part_detail').val();
                console.log(car_part_details);
                $('#AddPartTextModal').modal('hide');
                return false;
            });
            
            $(document).on('submit', '#save_order_details', function(){
                $('.module_save_btn').attr('disabled', 'disabled');
            });
        });
    </script>
@stop