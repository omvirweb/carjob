<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Cars;
use App\Models\CarModels;
use App\Models\User;
use App\Models\OrdersCarPartsDetails;
use Auth;
use File;
use URL;
use Session;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        return view('admin.Order.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data = array();
        $cars = Cars::All();
        $carmodels = CarModels::All();
        $users = User::All();
        return view('admin.Order.create', $data, compact('cars', 'carmodels', 'users'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if(!empty($request->id)){
            $order = Orders::where('id', $request->id)->first();
        } else {
            $order = new Orders();
            $order->order_time = date("H:i:s");
        }
        $order->name = !empty($request->name) ? $request->name : NULL;
        $order->mobile_no = !empty($request->mobile_no) ? $request->mobile_no : NULL;
        $order->order_date = !empty($request->order_date) ? date("Y-m-d", strtotime($request->order_date)) : NULL;
        $order->car_id = !empty($request->car_id) ? $request->car_id : 0;
        $order->car_model_id = !empty($request->car_model_id) ? $request->car_model_id : 0;
        $order->model_year = !empty($request->model_year) ? $request->model_year : NULL;
        $order->mileage = !empty($request->mileage) ? $request->mileage : NULL;
        $order->receiver_id = !empty($request->receiver_id) ? $request->receiver_id : 0;
        $order->expected_delivery_date = !empty($request->expected_delivery_date) ? date("Y-m-d", strtotime($request->expected_delivery_date)) : NULL;
        $order->price = !empty($request->price) ? $request->price : 0;
        $order->save();

        $return = array();
        if($order->id){
            if(!empty($request->car_part_details)){
                $car_part_details = json_decode($request->car_part_details);
//                print_r($car_part_details); exit;
                foreach($car_part_details as $car_part_detail){
                    if(!empty($car_part_detail->car_part_detail_id)){
                        $orders_car_parts_details = OrdersCarPartsDetails::where('id', $car_part_detail->car_part_detail_id)->first();
                        $car_part_image = $orders_car_parts_details->car_part_image;
                    } else {
                        $orders_car_parts_details = new OrdersCarPartsDetails();
                        $car_part_image = NULL;
                    }

                    if (isset($car_part_detail->car_part_clicked) && $car_part_detail->car_part_clicked == '1' && $request->file('car_part_image') != '') {
                        // Create car_part_image Folder
                        $car_part_image_path = public_path('uploads/car_part_image/');
                        if(!File::isDirectory($car_part_image_path)){
                            File::makeDirectory($car_part_image_path, 0777, true, true);
                        }
//                        @unlink(public_path('uploads/car_part_image/'.$orders_car_parts_details->car_part_image));
                        $car_part_image = time() . '_' . uniqid() . '.' . $request->file('car_part_image')->getClientOriginalExtension();
                        $request->file('car_part_image')->move(public_path('uploads/car_part_image/'), $car_part_image);
                    }

                    $orders_car_parts_details->order_id = $order->id;
                    $orders_car_parts_details->car_part_name = $car_part_detail->car_part_name;
                    $orders_car_parts_details->car_part_detail = $car_part_detail->car_part_detail;
                    $orders_car_parts_details->car_part_image = $car_part_image;
                    $orders_car_parts_details->save();
                }
                
                $car_part_details = OrdersCarPartsDetails::where('order_id', $order->id)->get();
                if(!empty($car_part_details)){
                    $car_part_details_arr = Array();
                    foreach($car_part_details as $car_part_detail){
                        $car_part_detail_arr = Array();
                        $car_part_detail_arr['car_part_detail_id'] = $car_part_detail->id;
                        $car_part_detail_arr['order_id'] = $car_part_detail->order_id;
                        $car_part_detail_arr['car_part_name'] = $car_part_detail->car_part_name;
                        $car_part_detail_arr['car_part_detail'] = $car_part_detail->car_part_detail;
                        $car_part_detail_arr['car_part_image'] = $car_part_detail->car_part_image;
                        $car_part_detail_arr['car_part_clicked'] = '0';
                        $car_part_details_arr[] = $car_part_detail_arr;
                    }
                    $return['car_part_details'] = json_encode($car_part_details_arr);
                }
            }

    //        Session::flash('status', 'success');
    //        Session::flash('message', 'Order Successfully Created');
            $return['order_id'] = $order->id;
            
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order_data = Orders::find($id);
        if (!empty($order_data)) {
            $data = array();
            $order_data->order_date = !empty($order_data->order_date) ? date("d-m-Y", strtotime($order_data->order_date)) : '';
            $order_data->order_time = !empty($order_data->order_time) ? date("h:i A", strtotime($order_data->order_time)) : '';
            $order_data->expected_delivery_date = !empty($order_data->expected_delivery_date) ? date("d-m-Y", strtotime($order_data->expected_delivery_date)) : '';
            $car_part_details = OrdersCarPartsDetails::where('order_id', $order_data->id)->get();
            if(!empty($car_part_details)){
                $car_part_details_arr = Array();
                foreach($car_part_details as $car_part_detail){
                    $car_part_detail_arr = Array();
                    $car_part_detail_arr['car_part_detail_id'] = $car_part_detail->id;
                    $car_part_detail_arr['order_id'] = $car_part_detail->order_id;
                    $car_part_detail_arr['car_part_name'] = $car_part_detail->car_part_name;
                    $car_part_detail_arr['car_part_detail'] = $car_part_detail->car_part_detail;
                    $car_part_detail_arr['car_part_image'] = $car_part_detail->car_part_image;
                    $car_part_detail_arr['car_part_clicked'] = '0';
                    $car_part_details_arr[] = $car_part_detail_arr;
                }
                $order_data->car_part_details = json_encode($car_part_details_arr);
            }
            $data['order_data'] = $order_data;
            $cars = Cars::All();
            $carmodels = CarModels::All();
            $users = User::All();
            return view('admin.Order.create', $data, compact('cars', 'carmodels', 'users'));
        } else {
            return redirect('admin_404')->with(['status' => 'warning', 'message' => ' User not found !!!']);
        }
    }

    public function getOrdersDatatable(Request $request) {
        $data = $request->all();
        $search_value = trim($data['search']['value']);
        $user = auth()->user();
        $orderQuery = Orders::select(DB::raw('orders.*, users.first_name, cars.car_name, car_models.model_name, DATE_FORMAT(orders.order_date, "%d-%m-%Y") as order_date_format, DATE_FORMAT(orders.order_time, "%h:%i %p") as order_time_format, DATE_FORMAT(orders.expected_delivery_date, "%d-%m-%Y") as expected_delivery_date_format, DATE_FORMAT(orders.created_at, "%d-%m-%Y") as created_at_format'))
            ->leftJoin('users', 'users.id', '=', 'orders.receiver_id')
            ->leftJoin('cars', 'cars.id', '=', 'orders.car_id')
            ->leftJoin('car_models', 'car_models.id', '=', 'orders.car_model_id');
//            ->when($search_value, function ($orderQuery) use ($search_value,$request) {
//                return $orderQuery->where(function ($orderQuery) use ($search_value,$request) {
//                    /** @var Builder $orderQuery */
//                    $preparedQ = '%' .$search_value. '%';
//                    $num = 0;
//                    foreach (
//                        [
//                            'users.first_name',
//                        ] AS $field
//                    ) {
//                        if ($num) {
//                            $orderQuery = $orderQuery->orWhere($field, 'LIKE', $preparedQ);
//                        } else {
//                            $orderQuery = $orderQuery->where($field, 'LIKE', $preparedQ);
//                        }
//                        $num++;
//                    }
//                    return $orderQuery;
//                });
//            });

        $orderQuery->orderBy('orders.created_at', 'DESC');
        return datatables()->of($orderQuery)->toJson();
    }

    public function orderDelete(Request $request)
    {
        $order = Orders::find($request->delete_order_id);
        $order_car_part_details = OrdersCarPartsDetails::where('order_id',$request->delete_order_id)->get();
        if(!empty($order_car_part_details)){
            foreach ($order_car_part_details as $order_car_part_detail){
//                @unlink(public_path('uploads/car_part_image/'.$order_car_part_detail->car_part_image));
                $order_car_part_detail->delete();
            }
        }
        $order->delete();
        \Session::flash('danger', 'Order Successfully Deleted.');
        return redirect()->back();
    }
}
