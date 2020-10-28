{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Create Item Details')

@section('content_header')
<h1>Create Item Details</h1>
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
        {{ Form::open(['route' => 'item-details.store', 'id' => 'save_item_details', 'enctype' => 'multipart/form-data']) }}

        {{ csrf_field() }}
        {{ Form::hidden('id', $item_details_data->id ?? '') }}
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('categoryid', 'Category', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control text-capitalize" id="categoryid" name="categoryid">
                        <option>Select</option>
                        @forelse($getAllCategory as $ckey => $cvalue)
                            <option value="<?= $cvalue['id'] ?>" <?php if(isset($item_details_data->categoryid) && $item_details_data->categoryid == $cvalue['id']) { echo 'Selected'; } ?> ><?= $cvalue['categoryName'] ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('itemid', 'Item', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    <select class="form-control text-capitalize" id="itemid" name="itemid">
                        <option>Select</option>
                        @forelse($getAllItem as $ikey => $ivalue)
                            <option value="<?= $ivalue['id'] ?>" <?php if(isset($item_details_data->itemid) && $item_details_data->itemid == $ivalue['id']) { echo 'Selected'; } ?> ><?= $ivalue['itemName'] ?></option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {{ Form::label('weight', 'Weight', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('weight', $item_details_data->weight ?? '', ['class' => 'form-control num_only', 'style' => 'padding: 5px 5px;']) }}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {{ Form::label('less', 'Less', ['class' => 'control-label']) }}
                    {{ Form::text('less', $item_details_data->less ?? '', ['class' => 'form-control num_only', 'style' => 'padding: 5px 5px;']) }}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {{ Form::label('net_wt', 'Net Wt.', ['class' => 'control-label']) }}
                    {{ Form::text('net_wt', $item_details_data->net_wt ?? '', ['class' => 'form-control num_only', 'style' => 'padding: 5px 5px;', 'readonly']) }}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {{ Form::label('purity', 'Purity', ['class' => 'control-label']) }}
                    {{ Form::text('purity', $item_details_data->purity ?? '', ['class' => 'form-control num_only']) }}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {{ Form::label('fine', 'Fine', ['class' => 'control-label']) }}
                    {{ Form::text('fine', $item_details_data->fine ?? '', ['class' => 'form-control num_only', 'style' => 'padding: 5px 5px;', 'readonly']) }}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {{ Form::label('size', 'Size', ['class' => 'control-label']) }}
                    {{ Form::text('size', $item_details_data->size ?? '', ['class' => 'form-control num_only']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('remarks', 'Remarks', ['class' => 'control-label']) }}
                    {{ Form::text('remarks', $item_details_data->remarks ?? '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('item_image', 'Image', ['class' => 'control-label']) }}
                    {{ Form::file('item_image', []) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group"><br />
                    {{ Form::label('item_available', 'Available?', ['class' => 'control-label']) }}
                    {{ Form::checkbox('item_available', '1', $item_details_data->item_available ?? '[checked]') }}
                </div>
            </div>
        </div>
        
        {{ Form::submit('Save', ['class' => 'btn btn-primary module_save_btn']) }}
        
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
            
            $(document).on('keyup change', "#weight, #less", function () {
                var weight = $('#weight').val() || 0;
                var less = $('#less').val() || 0;
                var net_wt = parseFloat(weight) - parseFloat(less);
                $('#net_wt').val(parseFloat(net_wt).toFixed(3));
                $('#net_wt').change();
            });
            
            $(document).on('keyup change', "#net_wt, #purity", function () {
                var net_wt = $('#net_wt').val() || 0;
                var purity = $('#purity').val() || 0;
                var fine = parseFloat(net_wt) * parseFloat(purity) / 100;
                $('#fine').val(parseFloat(fine).toFixed(3));
            });
            
            $(document).on('submit', '#save_item_details', function(){
                $('.module_save_btn').attr('disabled', 'disabled');
            });
        });
    </script>
@stop