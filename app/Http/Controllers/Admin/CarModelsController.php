<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModels;
use Illuminate\Http\Request;

class CarModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function edit(CarModels $carModels)
    {
        //
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
