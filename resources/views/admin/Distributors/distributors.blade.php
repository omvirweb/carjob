{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Distributor')
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
    <h1>Distributor</h1>
@stop

@section('content')
    <div class="modal fade" id="basic" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Distributor</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addnewdistributor_add_form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">First Name: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="first_name" id="first_name" placeholder="Enter First Name" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Last Name: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="last_name" id="last_name" placeholder="Enter Last Name" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Email: </label>
                                        <div class="col-md-12">
                                            <input type="email" class="form-control"  name="email" id="email" placeholder="Enter email Name" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Phone Number: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="phone_number" id="phone_number" placeholder="Enter phone number" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Password: </label>
                                        <div class="col-md-12">
                                            <input type="password" class="form-control"  name="password" id="password" placeholder="Enter Password" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Confirm Password: </label>
                                        <div class="col-md-12">
                                            <input type="password" class="form-control"  name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Address: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="address" id="address" placeholder="Enter Address">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">City: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="city" id="city" placeholder="Enter city">
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
                                            <input name="distributorstatus" type="radio" id="radio_31" class="with-gap radio-col-pink" value="0" checked />
                                            <label for="radio_31">Active</label>
                                            <input name="distributorstatus" type="radio" id="radio_30" class="with-gap radio-col-red" value="1" />
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

    <div class="modal fade" id="distributoredit" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Distributor</h4>
                </div>
                <div class="modal-body">
                  <form action="" method="post" id="editnewdistributor_form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">First Name: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="efirst_name" id="efirst_name" placeholder="Enter First Name" required>
                                            <input type="hidden" class="form-control"  name="eid" id="eid" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Last Name: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="elast_name" id="elast_name" placeholder="Enter Last Name" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Email: </label>
                                        <div class="col-md-12">
                                            <input type="email" class="form-control"  name="eemail" id="eemail" placeholder="Enter email Name" readonly="">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Phone Number: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="ephone_number" id="ephone_number" placeholder="Enter phone number" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Address: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="eaddress" id="eaddress" placeholder="Enter Address" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">City: </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"  name="ecity" id="ecity" placeholder="Enter city" required>
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
                                            <input name="edistributorstatus" type="radio" id="eradio_31" class="with-gap radio-col-pink" value="0" checked />
                                            <label for="eradio_31">Active</label>
                                            <input name="edistributorstatus" type="radio" id="eradio_30" class="with-gap radio-col-red" value="1" />
                                            <label for="eradio_30">Inactive</label>
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

                    <p>Are you sure you want remove this distributor ?</p>
                    <form action="{{url('admin/distributorDelete')}}" method="post" id="dform">
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
                            <form action="{{ url('/admin/distributorList')}}">
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($Distributors->toArray()['data']))
                                    @foreach($Distributors as $key => $value)
                                        <tr>
                                            <td>{{ $value->first_name }}</td>
                                            <td>{{ $value->last_name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->mobile_number }}</td>
                                            <td ><div class="font-weight-bold" >@if($value->isActive == '0') <b style="color: green">{{ 'Active' }}</b> @else <b style="color: red">{{ 'Inactive' }}</b> @endif </div></td>
                                            <td>
                                                
                                                <button class="btn btn-xs btn-primary edit_distributor" data-id="{{ $value->id }}" title="Edit"><span class="fa fa-edit"></span></button> 
                                                <button class="btn btn-xs btn-danger delete_distributor" data-did="{{ $value->id }}" title="Delete"><span class="fa fa-trash"></span></button>
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
  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#addnewdistributor_add_form").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email:true
            },
            phone_number: {
                required: true,
                number:true
            },
            password: {
                required: true,
                minlength:7
            },
            confirm_password: {
                required: true,
                minlength: 7,
                equalTo:password
            }
        },
        submitHandler: function(form) {
            var first_name=$('#first_name').val();
            var last_name=$('#last_name').val();
            var email=$('#email').val();
            var phone_number=$('#phone_number').val();
            var password=$('#password').val();
            var address=$('#address').val();
            var city=$('#city').val();
            var distributorstatus= $("input:radio[name=distributorstatus]:checked").val();
            
            var form_data = new FormData();
                form_data.append('first_name', first_name);
                form_data.append('last_name', last_name);
                form_data.append('email', email);
                form_data.append('password', password);
                form_data.append('phone_number', phone_number);
                form_data.append('address', address);
                form_data.append('city', city);
                form_data.append('distributorstatus', distributorstatus);
            
            $.ajax({
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                url : "{{ url('/admin/distributorInsert') }}",
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

    $('.edit_distributor').click(function(){

        var id=$(this).data('id');
        $.ajax({
            type: 'POST',
            url : "{{ url('/admin/getDistributor') }}",
            data:{id:id},
            dataType:'JSON',
            success : function (data) {

                $('#eid').val(data.id);
                $('#efirst_name').val(data.first_name);
                $('#elast_name').val(data.last_name);
                $('#eemail').val(data.email);
                $('#ephone_number').val(data.mobile_number);
                $('#eaddress').val(data.address);
                $('#ecity').val(data.city);
                
                if(data.isActive == '0'){
                    $('#eradio_1').prop('checked',true);
                    $("#eradio_2").prop('checked', false);
                    
                }else{
                    $('#eradio_1').prop('checked',false);
                    $("#eradio_2").prop('checked', true);
                    
                }
                
                $('#distributoredit').modal('show');
            },error: function(xhr, ajaxOptions, thrownError){
                
                toastr.error('Internal server error, Please try after some time.', 'Error!');
            },
        });

    });

    $("#editnewdistributor_form").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            phone_number: {
                required: true,
                number:true
            }
        
        },
        submitHandler: function(form) {
            var eid=$('#eid').val();
        
            var first_name=$('#efirst_name').val();
            var last_name=$('#elast_name').val();
            var phone_number=$('#ephone_number').val();
            var address=$('#eaddress').val();
            var city=$('#ecity').val();
            var distributorstatus= $("input:radio[name=edistributorstatus]:checked").val();
            
            var form_data = new FormData();
                form_data.append('eid', eid);
                form_data.append('first_name', first_name);
                form_data.append('last_name', last_name);
                form_data.append('phone_number', phone_number);
                form_data.append('address', address);
                form_data.append('city', city);
                form_data.append('distributorstatus', distributorstatus);
            
            $.ajax({
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                url : "{{ url('/admin/distributorUpdate') }}",
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

    $('.delete_distributor').click(function(){

        var id=$(this).data('did');
        $('#did').val(id);
        $('#dbasic').modal('show');

    });


</script>
@stop