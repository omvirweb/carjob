{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Item')
@section('extracss')
  <link href="{{ asset('toastr/build/toastr.min.css') }}" rel="stylesheet">
<style type="text/css">
    .select2{
        width: 100% !important;
    }
    .fileinput-exists .fileinput-new, .fileinput-new .fileinput-exists {
        display: none;
    }
     .error{
            color: red;
        }
    .thumbnail {
    display: block;
    /*padding: 4px;*/
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
    }
    .btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    }
    .btn-file > input {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        font-size: 23px;
        cursor: pointer;
        filter: alpha(opacity=0);
        opacity: 0;
        direction: ltr;
    }
    .fileinput .btn {
        vertical-align: middle;
    }
    .btn-file {
        position: relative;
        overflow: hidden;
        vertical-align: middle;
    }
    .btn-default {
        background-color: #F1F1F1;
    }
    .btn-default {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }
</style>
@section('content_header')
    <h1>Item</h1>
@stop

@section('content')
    <div class="modal fade" id="basic" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new Item</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addnewitem_add_form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Item Name: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="item_name" id="item_name" placeholder="Enter item Name" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Category Name: </label>
                                        <div class="col-md-12">
                                            <select class="form-control text-capitalize" id="categoryid" name="categoryid">
                                            <option>Select</option>
                                            @forelse($getAllCategory as $ckey => $cvalue)
                                                <option value="<?= $cvalue['id'] ?>"><?= $cvalue['categoryName'] ?></option>
                                            @empty

                                            @endforelse
                                        </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Select Image: </label>
                                        <div class="col-md-12">
                                            <input type="file" class="form-control"  name="doc_file1" id="doc_file1" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Status: </label>
                                        <div class="col-md-10">
                                            <input name="itemstatus" type="radio" id="radio_31" class="with-gap radio-col-pink" value="0" checked />
                                            <label for="radio_31">Active</label>
                                            <input name="itemstatus" type="radio" id="radio_30" class="with-gap radio-col-red" value="1" />
                                            <label for="radio_30">Inactive</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="categoriesedit" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Item</h4>
                </div>
                <div class="modal-body">
                  <form action="" method="post" id="editnewcategories_form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Item Name: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="eitem_name" id="eitem_name" placeholder="Enter item name" required>
                                            <input type="hidden" class="form-control"  name="eid" id="eid" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Category Name: </label>
                                        <div class="col-md-12">
                                            <select class="form-control text-capitalize" id="ecategoryid" name="ecategoryid">
                                            <option>Select</option>
                                            @forelse($getAllCategory as $ckey => $cvalue)
                                                <option value="<?= $cvalue['id'] ?>"><?= $cvalue['categoryName'] ?></option>
                                            @empty

                                            @endforelse
                                        </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group row">
                                        <label class="col-md-9 control-label">Select Image: </label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control"  name="edoc_file1" id="edoc_file1">
                                            <input type="hidden" class="form-control"  name="fileuploadval" id="fileuploadval" value="0">
                                        </div>
                                        <div class="col-md-6 showimg">
                                            
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Status: </label>
                                        <div class="col-md-10">
                                            <input name="eitemstatus" type="radio" id="radio_1" class="with-gap radio-col-pink" value="0" checked />
                                            <label for="radio_1">Active</label>
                                            <input name="eitemstatus" type="radio" id="radio_2" class="with-gap radio-col-red" value="1" />
                                            <label for="radio_2">Inactive</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        
                    
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="dbasic" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">

                    <p>Are you sure you want remove this item ?</p>
                    <form action="{{url('admin/itemDelete')}}" method="post" id="dform">
                        @csrf
                        <input type="hidden" name="did" id="did">

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">No</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
   
    <div class="row">
        <!-- column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                     <div class="row">
                        <div class="card-title-elements col-3">
                            <button type="button" class="btn btn-info d-block pull-right" data-toggle="modal" data-target="#basic"><span class="fa fa-plus"></span>&nbsp; Add </button>

                        </div>
                        <div class="col-9">
                            <form action="{{ url('/admin/itemList')}}">
                                <div class="form-row">
                                
                                    <div class="col-md col-xl-3 mb-4">
                                        <input type="text" name="search" class="form-control" placeholder="Search By name" value="">
                                    </div>
                                    <div class="col-md col-xl-2 mb-4">
                                        <button type="submit" class="btn btn-info btn-block">Search</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table color-table success-table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Category Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($Item->toArray()['data']))
                                    @foreach($Item as $key => $value)
                                        <tr>
                                            <td>{{ $value->itemName }}</td>
                                            <td>{{ $value->categoryName }}</td>
                                            <td><img class="card-img-top" src="@if($value->image != '') {{ url('/').'/uploads/item/'.$value->image }} @else {{ 'http://placehold.it/200x200' }}  @endif " alt="Card image" style="width: 100px;"></td>
                                            <td ><div class="font-weight-bold" >@if($value->status == '0') <b style="color: green">{{ 'Active' }}</b> @else <b style="color: red">{{ 'Inactive' }}</b> @endif </div></td>
                                            <td>
                                                
                                                <button class="btn btn-xs btn-primary edit_categories" data-id="{{ $value->id }}" title="Edit"><span class="fa fa-edit"></span></button> 
                                                <button class="btn btn-xs btn-danger delete_categories" data-did="{{ $value->id }}" title="Delete"><span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">no data found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                {{$links}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
<script src="{{ asset('toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.validate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
    
<script>
    var path = "{{asset('uploads/item/')}}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#addnewitem_add_form").validate({
        rules: {
            item_name: {
                required: true
            },
            categoryid: {
                required: true
            }
        },
        submitHandler: function(form) {
            var item_name=$('#item_name').val();
            var categoryid=$('#categoryid').val();
            var doc_file1=$('#doc_file1').prop('files')[0];
            var itemstatus= $("input:radio[name=itemstatus]:checked").val();
            
            var form_data = new FormData();
                form_data.append('item_name', item_name);
                form_data.append('categoryid', categoryid);
                form_data.append('itemstatus', itemstatus);
                form_data.append('doc_file1', doc_file1);
            
            $.ajax({
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                url : "{{ url('/admin/itemInsert') }}",
                dataType:'JSON',
                async: false,
                success : function (data) {
                    
                    if(data.error == true){
                            
                            toastr.error(data.message, 'Error!');
                            return;
                    }else{

                        toastr.success(data.message, 'Success');

                            var myVar = setInterval(
                                    location.reload()
                                    , 500000);
                    }
                },error: function(xhr, ajaxOptions, thrownError){
                    
                     toastr.error('Internal server error, Please try after some time.', 'Error!');
                },
            });
        }
    });

    $('.edit_categories').click(function(){

        var id=$(this).data('id');
        $.ajax({
            type: 'POST',
            url : "{{ url('/admin/getItem') }}",
            data:{id:id},
            dataType:'JSON',
            success : function (data) {

                $('#eid').val(data.id);
                $('#eitem_name').val(data.itemName);
                $('#ecategoryid').val(data.categoryId);
                
                if(data.status == '0'){
                    $('#radio_1').prop('checked',true);
                    $("#radio_2").prop('checked', false);
                    
                }else{
                    $('#radio_1').prop('checked',false);
                    $("#radio_2").prop('checked', true);
                    
                }

                var innerHtml = '';
                if(data.image != ''){
                    innerHtml += '<img src="'+path +'/'+ data.image+'" alt="profile pic" style="width: 100px;">';
                }else{
                    innerHtml += '<img src="http://placehold.it/200x200" alt="profile pic" style="width: 100px;">';
                }
                
                
                $('.showimg').html(innerHtml);
                
                $('#categoriesedit').modal('show');
            },error: function(xhr, ajaxOptions, thrownError){
                
                toastr.error('Internal server error, Please try after some time.', 'Error!');
            },
        });

    });

    $('#edoc_file1').change(function () {

        $('#fileuploadval').val('1');

    });

    $("#editnewcategories_form").validate({
        rules: {
            eitem_name: {
                required: true
            },
            ecategoryid: {
                required: true
            }
        },
        submitHandler: function(form) {
            var eid=$('#eid').val();
        
            var item_name=$('#eitem_name').val();
            var categoryid=$('#ecategoryid').val();
            var doc_file1=$('#edoc_file1').prop('files')[0];
            var fileuploadval=$('#fileuploadval').val();
            var itemstatus= $("input:radio[name=eitemstatus]:checked").val();
            
            var form_data = new FormData();
                form_data.append('eid', eid);
                form_data.append('item_name', item_name);
                form_data.append('categoryid', categoryid);
                form_data.append('itemstatus', itemstatus);
                form_data.append('fileuploadval', fileuploadval);
                form_data.append('doc_file1', doc_file1);
            
            $.ajax({
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                url : "{{ url('/admin/itemUpdate') }}",
                dataType:'JSON',
                async: false,
                success : function (data) {
                    $('.preloader').hide();
                    if(data.error == true){
                            toastr.error(data.message, 'Error!');
                            return;
                    }else{
                        toastr.success(data.message, 'Success');

                            var myVar = setInterval(
                                    location.reload()
                                    , 500000);
                    }

                },error: function(xhr, ajaxOptions, thrownError){
                    toastr.error('Internal server error, Please try after some time.', 'Error!');
                },
            });
        }
    });

    $('.delete_categories').click(function(){

        var id=$(this).data('did');
        $('#did').val(id);
        $('#dbasic').modal('show');

    });


</script>
@stop