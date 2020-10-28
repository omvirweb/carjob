@extends('layouts/default')
@section('title','Main')
@section('extracss')

@endsection

@section('content')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./index.php" title="Categories">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Items : &nbsp;</li>
    <li class="active" aria-current="page">Ladies Ring</li>
  </ol>
</nav>

<!-- Search form -->
<!-- Search form -->
<div class="md-form active-cyan active-cyan-2 mb-3 item_search">
  <input class="form-control" type="text" placeholder="Search Design No." aria-label="Search Design No.">
</div>

<div class="row item_list">
    @forelse($getAllItem as $ckey => $cvalue)
        <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <img class="card-img-top" src="@if($cvalue['image'] != '') {{ url('/').'/uploads/item/'.$cvalue['image'] }} @else {{ 'http://placehold.it/200x200' }}  @endif" alt="Card image">
            </div>
            <div class="card-body table">
                <table class="table table-bordered table-primary">
                    <tr>
                        <th>Design No.</th>
                        <td>12121</td>
                    </tr>
                    <tr>
                        <th>Grwt</th>
                        <td>100</td>
                    </tr>
                    <tr>
                        <th>Less</th>
                        <td>10</td>
                    </tr>
                    <tr>
                        <th>Net Wt</th>
                        <td>90</td>
                    </tr>
                    <tr>
                        <th>Purity</th>
                        <td>92</td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td>10</td>
                    </tr>
                    <tr>
                        <th>Select</th>
                        <td><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <th>Make to Order</th>
                        <td><input type="text" class="form-control" value="10"></td>
                    </tr>
                </table>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal"> Customise </button>
            </div>
        </div>
    </div>
    @empty

    @endforelse
    
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Design No. : 12121</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table class="table table-bordered table-warning">
                    <tr>
                        <th>Purity</th>
                        <td><input type="text" class="form-control" value="92"></td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td><input type="text" class="form-control" value="10"></td>
                    </tr>
                    <tr>
                        <th>Approx Net Weight</th>
                        <td><input type="text" class="form-control" value="92"></td>
                    </tr>
                    <tr>
                        <th>Gold</th>
                        <td>
                            <select class="form-control">
                                <option value="1">Yellow Gold</option>
                                <option value="2">Rose Gold</option>
                                <option value="3">White Gold</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Color Stone Change?</th>
                        <td>
                            <select class="form-control">
                                <option value="1">Y</option>
                                <option value="2">N</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Describe Changes</th>
                        <td><input type="text" class="form-control" value=""></td>
                    </tr>
                    <tr>
                        <th>Rhodium</th>
                        <td><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <th>Other Description</th>
                        <td><textarea class="form-control"></textarea></td>
                    </tr>
                </table>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>



@endsection

@section('extrajs')


@endsection