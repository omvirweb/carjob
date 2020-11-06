{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
<h1>Profile</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if (Session::get('status') && Session::has('message'))
            <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
        @endif
        <div id="error_msg"></div>
        <form class="" id="save_customer" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ Form::hidden('id', $userDetails->id ?? '') }}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('first_name', 'Company Name', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('first_name', $userDetails->first_name ?? '', ['class' => 'form-control', 'placeholder' => 'Company Name']) }}
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    {{ Form::label('address', 'Address', ['class' => 'control-label']) }}
                    {{ Form::textarea('address', $userDetails->address ?? '', ['class' => 'form-control', 'placeholder' => 'Address', 'rows' => '1']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('email', 'Email', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::email('email', $userDetails->email ?? '', ['class' => 'form-control', 'placeholder' => 'Email']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('confirm_password', 'Confirm Password', ['class' => 'control-label']) }}
                    {{ Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('company_logo', 'Company Logo', ['class' => 'control-label']) }}
                    {{ Form::file('company_logo', []) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <img src="{{asset('uploads/company_logo/' . $userDetails->city)}}" style="height:90px;" alt="Logo" title="Logo" />
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary module_save_btn">Save</button>
        </form>
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

            $(document).on('submit', '#save_customer', function(){
                var postData = new FormData(this);
                postData.append('csrf', '{{ csrf_field() }}');
                $.ajax({
                    url: "{{ URL::to('/admin/updateProfile') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: postData,
                    datatype: 'json',
                    async: false,
                    success: function (response) {
//                        $('.changepassword_btn').removeAttr('disabled', 'disabled');
                        var json = $.parseJSON(response);
                        if (json['errors']) {
                            var error_msg_html = '<div class="alert alert-danger"><ul>';
                            $(json['errors']).each(function( index,value ) {
                                error_msg_html += '<li>'+value+'</li>';
                            });
                            error_msg_html += '</ul></div>';
                            $('#error_msg').html(error_msg_html);
                        } else {
                            $('#error_msg').html('');
                        }  
                        if (json['success']) {
                            window.location.href = "{{ URL::to('/admin/profile') }}";
                        }
                    },
                });
                return false;
            });
        });
    </script>
@stop