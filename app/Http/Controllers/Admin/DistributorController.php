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
use Illuminate\Support\Facades\Hash;
use App\Services\DistributorService; 

class DistributorController extends Controller
{
    const ELEMENTS_PER_PAGE = self::DEFAULT_ELEMENTS_PER_PAGE;

    public function distributorList(Request $request, DistributorService $DistributorService)
    {
        $data = $DistributorService->getDistributors($request, self::ELEMENTS_PER_PAGE);
        
        return view('admin.Distributors.distributors', $data);
    }

    public function distributorInsert(Request $request)
    {

        try {
            $email = $request->email;
            
            $addUserName = User::where('email', '=', $email)->first();
            if (empty($addUserName)) {
                $addUser = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'mobile_number' => $request->phone_number,
                    'address' => $request->address,
                    'city' => $request->city,
                    'role'=>User::ROLE_DISTRIBUTOR,
                    'isActive' => $request->distributorstatus
                ]);

                return response()->json(['error' => false, 'message' => 'User added successfully']);
            } else {
                return response()->json(['error' => true, 'message' => 'User name already added']);
            }
        } catch (\Throwable $th) {
        	dd($th);
            return $this->sendError(trans('server_error'), []);

        }

    }

    public function getDistributor(Request $request)
    {

        $distributorDetails = User::find($request->id);
        echo json_encode($distributorDetails);
    }

    public function distributorUpdate(Request $request)
    {
        try {
            
            $UserUpdate = User::find($request->eid);
            $UserUpdate->first_name = $request->first_name;
            $UserUpdate->last_name = $request->last_name;
        	$UserUpdate->mobile_number = $request->phone_number;
            $UserUpdate->address = $request->address;
            $UserUpdate->city = $request->city;
            $UserUpdate->isActive = $request->distributorstatus;
            $UserUpdate->save();

            return response()->json(['error' => false, 'message' => 'User name update successfully']);
            
        } catch (\Throwable $th) {
        	dd($th);
            return $this->sendError('server error', []);

        }

    }

    public function distributorDelete(Request $request)
    {
        $getPage = User::find($request->did);
        $getPage->delete();

        return redirect()->route('distributorList')->with('status', 'User deleted successfully.');
    }
}
