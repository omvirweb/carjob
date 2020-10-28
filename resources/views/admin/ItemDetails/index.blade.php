{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Item Details')

@section('content_header')
<h1>Item Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ url('/admin/item-details')}}">
            <div class="form-row">
                <div class="col-md col-xl-3 mb-4">
                    <input type="text" name="search" class="form-control" placeholder="Search" value="">
                </div>
                <div class="col-md col-xl-2 mb-4">
                    <button type="submit" class="btn btn-info btn-block">Search</button>
                </div>
            </div>
        </form>
        @if (Session::has('message'))
            <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
        @endif
        <table id="item_details_list" class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Item</th>
                    <th class="text-right">Weight</th>
                    <th class="text-right">Less</th>
                    <th class="text-right">Net.Wt.</th>
                    <th class="text-right">Purity</th>
                    <th class="text-right">Fine</th>
                    <th class="text-right">Size</th>
                    <th>Remarks</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($ItemDetails->toArray()['data']))
                    @foreach($ItemDetails as $key => $value)
                        <tr>
                            <td><img class="card-img-top" src="@if($value->item_image != '') {{ url('/').'/uploads/item/'.$value->item_image }} @else {{ 'http://placehold.it/200x200' }}  @endif " alt="Item Details image" style="width: 80px;"></td>
                            <td>{{ $value->categoryName }}</td>
                            <td>{{ $value->itemName }}</td>
                            <td class="text-right">{{ $value->weight }}</td>
                            <td class="text-right">{{ $value->less }}</td>
                            <td class="text-right">{{ $value->net_wt }}</td>
                            <td class="text-right">{{ $value->purity }}</td>
                            <td class="text-right">{{ $value->fine }}</td>
                            <td class="text-right">{{ $value->size }}</td>
                            <td>{{ $value->remarks }}</td>
                            <td nowrap="nowrap">
                                <a class="btn btn-sm btn-info edit-btn" href="{{ URL::to('admin/item-details/' . $value->id . '/edit') }}"><i class="fa far fa-edit"></i></a>
                                <button class="btn btn-sm btn-danger delete-btn" data-href="{{ 'item-details_' . $value->id }}">
                                    <form action="{{ URL::to('admin/item-details/' . $value->id) }}" id="{{ 'item-details_' . $value->id }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <i class="fa fa-times-circle"></i>
                                    </form>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">no data found</td>
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
@stop

@section('js')
    <script src="{{asset('vendor/bootbox/bootbox.min.js') }}"></script>
    <script src="{{asset('js/comman.js') }}"></script>
@stop