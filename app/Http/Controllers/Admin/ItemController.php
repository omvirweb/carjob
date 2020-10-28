<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use View;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use URL;
use App\Models\User;
use App\Services\ItemService;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    const ELEMENTS_PER_PAGE = self::DEFAULT_ELEMENTS_PER_PAGE;

    // Budget Categories ---------------------------------------------------------------------------
    public function itemList(Request $request, ItemService $ItemService)
    {
        $data = $ItemService->getItem($request, self::ELEMENTS_PER_PAGE);
        $getAllCategory = Category::where('status', '=', '0')->get();
        return view('admin.Item.item', $data, compact('getAllCategory'));
    }

    public function itemInsert(Request $request)
    {

        try {
            $item_name = $request->item_name;
            $itemstatus = $request->itemstatus;
            $categoryid = $request->categoryid;
            
            if ($request->file('doc_file1') != "") {
                $document1 = time() . '_' . uniqid() . '.' . $request->file('doc_file1')->getClientOriginalExtension();
                $request->file('doc_file1')->move(public_path('uploads/item/'), $document1);
                $safeName1 = $document1;
            } else {
                $safeName1 = '';
            }
            $addItemName = item::where('itemName', '=', $item_name)->first();
            if (empty($addItemName)) {
                $addItem = item::create([
                    'itemName' => $item_name,
                    'categoryId' => $categoryid,
                    'image' => $safeName1,
                    'createdBy' => \Auth::user()->id,
                    'status' => $itemstatus
                ]);

                return response()->json(['error' => false, 'message' => 'item added successfully']);
            } else {
                return response()->json(['error' => true, 'message' => 'item name already added']);
            }
        } catch (\Throwable $th) {
        	dd($th);
            return $this->sendError(trans('server_error'), []);

        }

    }

    public function getItem(Request $request)
    {

        $categoriesDetails = item::find($request->id);
        echo json_encode($categoriesDetails);
    }

    public function itemUpdate(Request $request)
    {
        try {
            $item_name = $request->item_name;
            $addItemName = item::where('itemName', '=', $item_name)->where('id', '!=', $request->eid)->first();
            if (empty($addItemName)) {

                $ItemUpdate = item::find($request->eid);
                $ItemUpdate->itemName = $request->item_name;
                $ItemUpdate->categoryId = $request->categoryid;
                $fileuploadval = $request->fileuploadval;
            	if($fileuploadval == '1'){
            		if ($request->file('doc_file1') != "") {
		                @unlink(public_path() . 'uploads/item/' . $ItemUpdate->image);
		                $document1 = time() . '_' . uniqid() . '.' . $request->file('doc_file1')->getClientOriginalExtension();
		                $request->file('doc_file1')->move(public_path('uploads/item/'), $document1);
		                $ItemUpdate->image = $document1;
		            }
            	}
                $ItemUpdate->updatedBy = \Auth::user()->id;
                $ItemUpdate->status = $request->itemstatus;
                $ItemUpdate->save();

                return response()->json(['error' => false, 'message' => 'item name update successfully']);
            } else {
                return response()->json(['error' => true, 'message' => 'item name already added']);
            }
        } catch (\Throwable $th) {
        	dd($th);
            return $this->sendError('server error', []);

        }

    }

    public function itemDelete(Request $request)
    {
        $getPage = item::find($request->did);
        $getPage->delete();

        return redirect()->route('itemList')->with('status', 'item deleted successfully.');
    }

}
