@extends('layouts/default')
@section('title','Main')
@section('extracss')

@endsection

@section('content')

<div class="row category_list">
    <div class="col-md-12">
        <h4 class="text-center">Categories</h4>
    </div>
    @forelse($getAllCategory as $ckey => $cvalue)
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <a href="{{ url('/'.$cvalue['id'].'/product')}}" title="Items"><img class="card-img-top" src="@if($cvalue['image'] != '') {{ url('/').'/uploads/category/'.$cvalue['image'] }} @else {{ 'http://placehold.it/200x200' }}  @endif " alt="Card image"></a>
                </div>
                <div class="card-body">
                    <h4 class="card-title text-center mb-0"><a href="{{ url('/'.$cvalue['id'].'/product')}}" title="Items"><?= $cvalue['categoryName'] ?></a></h4>
                </div>
            </div>
        </div>
    @empty

    @endforelse
</div>



@endsection

@section('extrajs')


@endsection