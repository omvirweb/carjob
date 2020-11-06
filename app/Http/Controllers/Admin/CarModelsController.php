<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModels;
use App\Models\Cars;
use App\Models\Orders;
use Illuminate\Http\Request;
use Session;
use DB;

class CarModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $cars = Cars::All();
        return view('admin.CarModels.index', $data, compact('cars'));
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
            $car_model = CarModels::where('id', $request->id)->first();
        } else {
            $car_model = new CarModels();
        }
        $car_model->car_id = $request->car_id;
        $car_model->model_name = !empty($request->model_name) ? $request->model_name : NULL;
        $car_model->save();
        $return = array();
        if($car_model->id){
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
     * @param  \App\Models\CarModels  $carModels
     * @return \Illuminate\Http\Response
     */
    public function show(CarModels $carModels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarModels  $carModels
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $return = array();
        $return['car_model_data'] = CarModels::find($id);
        print json_encode($return);
        exit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarModels  $carModels
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarModels $carModels)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarModels  $carModels
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarModels $carModels)
    {
        //
    }

    public function getCarModelsDatatable(Request $request) {
        $data = $request->all();
        $search_value = trim($data['search']['value']);
        $user = auth()->user();
        $carModelQuery = CarModels::select(DB::raw('car_models.*, cars.car_name'))
            ->leftJoin('cars', 'cars.id', '=', 'car_models.car_id')
            ->when($search_value, function ($carModelQuery) use ($search_value,$request) {
                return $carModelQuery->where(function ($carModelQuery) use ($search_value,$request) {
                    /** @var Builder $carModelQuery */
                    $preparedQ = '%' .$search_value. '%';
                    $num = 0;
                    foreach (
                        [
                            'cars.car_name',
                            'car_models.model_name',
                        ] AS $field
                    ) {
                        if ($num) {
                            $carModelQuery = $carModelQuery->orWhere($field, 'LIKE', $preparedQ);
                        } else {
                            $carModelQuery = $carModelQuery->where($field, 'LIKE', $preparedQ);
                        }
                        $num++;
                    }
                    return $carModelQuery;
                });
            });
        $carModelQuery->orderBy('created_at', 'DESC');
        return datatables()->of($carModelQuery)->toJson();
    }

    public function carModelDelete(Request $request)
    {
        $carModel = CarModels::find($request->delete_car_model_id);
        $order_detail = Orders::where('car_model_id', $request->delete_car_model_id)->get();
        if($order_detail->count()>0){
            \Session::flash('status', 'danger');
            \Session::flash('message', "Car Model not allow to delete. Because it's Used.");
            return redirect()->back();
        } else {
            $carModel->delete();
            \Session::flash('status', 'success');
            \Session::flash('message', 'Car Model Successfully Deleted.');
        }
        return redirect()->back();
    }

    public function getModelsByCar(Request $request) {
        $car_id = $request->car_id;
        $q = trim($request->q);
        if (empty($car_id)) {
            return \Response::json([]);
        }
        $car_models = CarModels::where('car_id', $car_id)->where('model_name', 'LIKE', "%$q%")->limit(5)->get();
        $formatted_car_models = [];
        foreach ($car_models as $car_model) {
            $formatted_car_models[] = ['id' => $car_model->id, 'text' => $car_model->model_name];
        }
        return \Response::json($formatted_car_models);
    }

    public function setCarModel($car_model_id) {
        $formatted_puritys = [];
        if(!empty($car_model_id)){
            if(!empty($car_model_id)){
                $car_models = CarModels::select('*')->where('id', $car_model_id)->get();
                foreach ($car_models as $car_model) {
                    $formatted_puritys[] = ['id' => $car_model->id, 'text' => $car_model->model_name];
                }
            }
        }
        return \Response::json($formatted_puritys);
    }

}
