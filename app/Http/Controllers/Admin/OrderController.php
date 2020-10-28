<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use File;
use URL;
use Session;

class OrderController extends Controller
{
    
    public function create() {
		$data = array();
        return view('admin.Order.create', $data);
    }
    
    public function store() {
		
    }
    
}
