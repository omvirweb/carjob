<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use App\Models\CarModels;
use Illuminate\Http\Request;
use Session;
use DB;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        return view('admin.Cars.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->id)){
            $order = Cars::where('id', $request->id)->first();
        } else {
            $order = new Cars();
        }
        $order->car_name = !empty($request->car_name) ? $request->car_name : NULL;
        $order->save();
        $return = array();
        if($order->id){
            if(!empty($request->id)){
                $return['success'] = "Updated";
            } else {
                $return['success'] = "Added";
            }
        }
        print json_encode($return);
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function show(Cars $cars)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $return = array();
        $return['car_data'] = Cars::find($id);
        print json_encode($return);
        exit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cars $cars)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cars $cars)
    {
        //
    }

    public function getCarsDatatable(Request $request) {
        $data = $request->all();
        $search_value = trim($data['search']['value']);
        $user = auth()->user();
        $carQuery = Cars::select(DB::raw('*'))
            ->when($search_value, function ($carQuery) use ($search_value,$request) {
                return $carQuery->where(function ($carQuery) use ($search_value,$request) {
                    /** @var Builder $carQuery */
                    $preparedQ = '%' .$search_value. '%';
                    $num = 0;
                    foreach (
                        [
                            'car_name',
                        ] AS $field
                    ) {
                        if ($num) {
                            $carQuery = $carQuery->orWhere($field, 'LIKE', $preparedQ);
                        } else {
                            $carQuery = $carQuery->where($field, 'LIKE', $preparedQ);
                        }
                        $num++;
                    }
                    return $carQuery;
                });
            });
        $carQuery->orderBy('created_at', 'DESC');
        return datatables()->of($carQuery)->toJson();
    }

    public function carDelete(Request $request)
    {
        $car = Cars::find($request->delete_car_id);
        $car_model_detail = CarModels::where('car_id', $request->delete_car_id)->get();
        if($car_model_detail->count()>0){
            \Session::flash('status', 'danger');
            \Session::flash('message', "Car not allow to delete. Because it's Used.");
            return redirect()->back();
        } else {
            $car->delete();
            \Session::flash('status', 'success');
            \Session::flash('message', 'Car Successfully Deleted.');
        }
        return redirect()->back();
    }
}
