{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Create Job Order')

@section('content_header')
<h1>Create Job Order</h1>
@stop

@section('content')
<style>
    input[type=checkbox]{
        height:22px;
        width:22px;
    } 
</style>
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
                    {{ Form::date('date', $item_details_data->date ?? '', ['id' => '', 'class' => 'form-control datepicker']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('time', 'Time', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::time('time', $item_details_data->date ?? '', ['id' => '', 'class' => 'form-control datepicker']) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="clearfix"></div><br/>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('mobile', 'Mobile', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('mobile', $item_details_data->mobile ?? '', ['id' => 'mobile', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('receiver_name', 'Receiver Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('receiver_name', $item_details_data->receiver_name ?? '', ['id' => 'receiver_name', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="clearfix"></div><br/>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('carid', 'Car', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control text-capitalize" id="carid" name="carid">
                        <option>Select</option>
                        <option>Mercedes</option>
                        <option>Hyundai</option>
                        <option>Tata</option>
                       
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('modelid', 'Model', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control text-capitalize" id="modelid" name="modelid">
                        <option>Select</option>
                        <option>A - Class</option>
                        <option>S - Class</option>
                        <option>C - Class</option>
                       
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('model_year', 'Model Year', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('model_year', $item_details_data->model_year ?? '', ['id' => 'model_year', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('mileage', 'Mileage', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('mileage', $item_details_data->mileage ?? '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('ex_delivery_date', 'Expected Date of Delivery', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('ex_delivery_date', $item_details_data->ex_delivery_date ?? '', ['id' => 'ex_delivery_date', 'class' => 'form-control']) }}
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('photo', 'Photo', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::file('photo', []) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('price', 'price', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('price', $item_details_data->price ?? '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="clearfix"></div><br/>
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
        
        {{ Form::button('Save', ['class' => 'btn btn-primary module_save_btn disabled'], 'disabled') }}
        <!--{{ Form::submit('Save', ['class' => 'btn btn-primary module_save_btn disabled'], 'disabled') }}-->
        
        {{ Form::close() }}
    </div>
</div>
@stop

@section('js')
    <script>
        $(document).ready( function(){
            
            
            
            
            $(document).on('input', ".num_only", function () {
                var textbox_value = this.value = this.value.replace(/[^\d\.\-]/g, '');
                var textbox_str = textbox_value.split(/\./);
                if(textbox_str.length > 2){
                    $(this).val('');
                }
            });
            
            
            $(document).on('submit', '#save_order_details', function(){
                $('.module_save_btn').attr('disabled', 'disabled');
            });
        });
    </script>
@stop