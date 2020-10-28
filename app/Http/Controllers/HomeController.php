<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show category list.
     */
    public function index()
    {
        $getAllCategory = Category::where('status', '=', '0')->get();
        //dd($getAllCategory);
        return view('index', compact('getAllCategory'));
    }

    /**
     * Show category product list.
     */
    public function product($id)
    {
        $getAllItem = Item::where('categoryId', '=', $id)->where('status', '=', '0')->get();
        //dd($getAllCategory);
        return view('product', compact('getAllItem'));
    }
}
