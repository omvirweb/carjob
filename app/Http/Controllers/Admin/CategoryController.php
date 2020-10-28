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
use App\Services\CategoriesService;
use App\Models\Category;

class CategoryController extends Controller
{
    const ELEMENTS_PER_PAGE = self::DEFAULT_ELEMENTS_PER_PAGE;

    // Budget Categories ---------------------------------------------------------------------------
    public function categoryList(Request $request, CategoriesService $CategoriesService)
    {
        $data = $CategoriesService->getCategories($request, self::ELEMENTS_PER_PAGE);
        
        return view('admin.Categories.categories', $data);
    }

    public function categoryInsert(Request $request)
    {

        try {
            $category_name = $request->category_name;
            $categorystatus = $request->categorystatus;
            
            if ($request->file('doc_file1') != "") {
                $document1 = time() . '_' . uniqid() . '.' . $request->file('doc_file1')->getClientOriginalExtension();
                $request->file('doc_file1')->move(public_path('uploads/category/'), $document1);
                $safeName1 = $document1;
            } else {
                $safeName1 = '';
            }
            $addCategoryName = category::where('categoryName', '=', $category_name)->first();
            if (empty($addCategoryName)) {
                $addcategory = category::create([
                    'categoryName' => $category_name,
                    'image' => $safeName1,
                    'createdBy' => \Auth::user()->id,
                    'status' => $categorystatus
                ]);

                return response()->json(['error' => false, 'message' => 'category added successfully']);
            } else {
                return response()->json(['error' => true, 'message' => 'category name already added']);
            }
        } catch (\Throwable $th) {
        	dd($th);
            return $this->sendError(trans('server_error'), []);

        }

    }

    public function getCategory(Request $request)
    {

        $categoriesDetails = category::find($request->id);
        echo json_encode($categoriesDetails);
    }

    public function categoryUpdate(Request $request)
    {
        try {
            $category_name = $request->category_name;
            $addCategoryName = category::where('categoryName', '=', $category_name)->where('id', '!=', $request->eid)->first();
            if (empty($addCategoryName)) {

                $CategoryUpdate = category::find($request->eid);
                $CategoryUpdate->categoryName = $request->category_name;
                $fileuploadval = $request->fileuploadval;
            	if($fileuploadval == '1'){
            		if ($request->file('doc_file1') != "") {
		                @unlink(public_path() . 'uploads/category/' . $CategoryUpdate->image);
		                $document1 = time() . '_' . uniqid() . '.' . $request->file('doc_file1')->getClientOriginalExtension();
		                $request->file('doc_file1')->move(public_path('uploads/category/'), $document1);
		                $CategoryUpdate->image = $document1;
		            }
            	}
                $CategoryUpdate->updatedBy = \Auth::user()->id;
                $CategoryUpdate->status = $request->categorystatus;
                $CategoryUpdate->save();

                return response()->json(['error' => false, 'message' => 'category name update successfully']);
            } else {
                return response()->json(['error' => true, 'message' => 'category name already added']);
            }
        } catch (\Throwable $th) {
        	dd($th);
            return $this->sendError('server error', []);

        }

    }

    public function categoryDelete(Request $request)
    {
        $getPage = category::find($request->did);
        $getPage->delete();

        return redirect()->route('categoryList')->with('status', 'category deleted successfully.');
    }

}
