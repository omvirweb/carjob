<?php

namespace App\Http\Controllers\Admin;

use App\Models\ItemDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Services\ItemDetailsService;
use Auth;
use File;
use URL;
use Session;

class ItemDetailsController extends Controller {

    const ELEMENTS_PER_PAGE = self::DEFAULT_ELEMENTS_PER_PAGE;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ItemDetailsService $ItemDetailsService) {
        $data = $ItemDetailsService->getItemDetails($request, self::ELEMENTS_PER_PAGE);
        return view('admin.ItemDetails.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = array();
        $getAllCategory = Category::where('status', '=', '0')->get();
        $getAllItem = Item::where('status', '=', '0')->get();
        return view('admin.ItemDetails.create', $data, compact('getAllCategory', 'getAllItem'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request,[
            'categoryid' => 'required',
            'itemid' => 'required|numeric',
            'weight' => 'required|numeric',
        ]);

        if(!empty($request->id)){
            $itemDetails = ItemDetails::where('id', $request->id)->first();
        } else {
            $itemDetails = new ItemDetails();
        }
        $itemDetails->categoryid = !empty($request->categoryid) ? $request->categoryid : 0;
        $itemDetails->itemid = !empty($request->itemid) ? $request->itemid : 0;
        $itemDetails->weight = !empty($request->weight) ? $request->weight : 0;
        $itemDetails->less = !empty($request->less) ? $request->less : 0;
        $itemDetails->net_wt = !empty($request->net_wt) ? $request->net_wt : 0;
        $itemDetails->purity = !empty($request->purity) ? $request->purity : 0;
        $itemDetails->fine = !empty($request->fine) ? $request->fine : 0;
        $itemDetails->size = !empty($request->size) ? $request->size : 0;
        $itemDetails->remarks = !empty($request->remarks) ? $request->remarks : 0;
        $itemDetails->item_available = !empty($request->item_available) ? '1' : '0';
        
        if ($request->file('item_image') != "") {
            $item_image = time() . '_' . uniqid() . '.' . $request->file('item_image')->getClientOriginalExtension();
            $request->file('item_image')->move(public_path('uploads/item/'), $item_image);
            $itemDetails->item_image = $item_image;
        } else {
            if(!empty($request->id)){ } else {
                $itemDetails->item_image = NULL;
            }
        }
        $itemDetails->save();

        Session::flash('status', 'success');
        if(!empty($request->id)){
            Session::flash('message', 'Item Details Successfully Updated');
        } else {
            Session::flash('message', 'Item Details Successfully Created');
        }
        return redirect()->route('item-details.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ItemDetails  $itemDetails
     * @return \Illuminate\Http\Response
     */
    public function show(ItemDetails $itemDetails) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ItemDetails  $itemDetails
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $item_details_data = ItemDetails::find($id);
        if (!empty($item_details_data)) {
            $item_details_data->item_available = ($item_details_data->item_available == '1') ? 'checked' : '';
            $getAllCategory = Category::where('status', '=', '0')->get();
            $getAllItem = Item::where('status', '=', '0')->get();
            return view('admin.ItemDetails.create', ['item_details_data' => $item_details_data], compact('getAllCategory', 'getAllItem'));
        } else {
            return redirect('admin_404')->with(['status' => 'warning', 'message' => ' Item Details not found !!!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ItemDetails  $itemDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemDetails $itemDetails) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemDetails  $itemDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $item_details_data = ItemDetails::find($id);
        if (!empty($item_details_data)) {
            $item_details_data->delete();

            Session::flash('status', 'success');
            Session::flash('message', 'Item Details Successfully Deleted');
            return redirect()->route('item-details.index');
        } else {
            return redirect('admin_404')->with(['status' => 'warning', 'message' => ' Item Details not found !!!']);
        }
    }

}
