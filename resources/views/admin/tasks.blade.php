{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Tasks')

@section('content_header')
<h1>Tasks</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {{ Form::open(['id' => 'save_order', 'method' => 'post', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '']) }}
        {{ csrf_field() }}
        {{ Form::hidden('id', ) }}
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('tasks', 'Tasks', ['class' => 'control-label']) }} <span class="text-danger">*</span>
                    {{ Form::text('task_name', '', ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        {{ Form::submit('Save', ['class' => 'btn btn-primary module_save_btn']) }}
        {{ Form::close() }}
        <table id="example1" class="table table-bordered table-striped mt-3">
            <thead>
              <tr>
                <th>Tasks</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($tasks as $item)
              <tr>
                <td>{{$item->task_name}}</td>
                <td><a href="delete/{{$item->id}}"><i class="fa fa-trash" style="margin-left:10px;color:red;"></i></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>
@stop