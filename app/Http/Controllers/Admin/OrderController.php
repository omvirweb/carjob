<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cars;
use App\Models\CarModels;
use App\Models\User;
use Auth;
use File;
use URL;
use Session;

class OrderController extends Controller
{
    
    public function create() {
        $data = array();
        $cars = Cars::All();
        $carmodels = CarModels::All();
        $users = User::All();
        return view('admin.Order.create', $data, compact('cars', 'carmodels', 'users'));
    }
    
    public function store() {
		
    }
    
}
