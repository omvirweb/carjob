<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use View;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use Validator;
use Session;
use File;

class AdminController extends Controller
{
    const ELEMENTS_PER_PAGE = self::DEFAULT_ELEMENTS_PER_PAGE;

    public function showHome()
    {
        $user = Auth::user();
        

        return view('admin.home');

    }

    public function changePassword()
    {
        return view('admin.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $profile = User::find(\Auth::user()->id);
        $profile->password = bcrypt($request->npassword);
        $profile->save();

        return response()->json(['error' => false, 'message' => trans('users/message.success.password_updated_successfully')]);
    }

    public function profile(Request $request)
    {
        $userDetails = User::find(\Auth::user()->id);
        return view('admin.profile', compact('userDetails'));
    }

    public function updateProfile(Request $request)
    {

        try {
            $return = array();
            $rules = [
                'first_name' => 'required',
                'email' => 'required|email|unique:users,email,'.$request->id,
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6',
            ];
            $validator = Validator::make($_POST, $rules);
            if ($validator->passes()) {
                if(!empty($request->id)){
                    $user = User::where('id', $request->id)->first();
                } else {
                    $user = new Customers();
                }
                $user->first_name = $request->first_name;
                $user->email = $request->email;
                if(!empty($request->password)){
                    $user->password = bcrypt($request->password);
                }
                $user->address = !empty($request->address) ? $request->address : NULL;
                if ($request->file('company_logo') != '') {
                    // Create company_logo Folder
                    $company_logo_path = public_path('uploads/company_logo/');
                    if(!File::isDirectory($company_logo_path)){
                        File::makeDirectory($company_logo_path, 0777, true, true);
                    }
                    $company_logo = time() . '_' . uniqid() . '.' . $request->file('company_logo')->getClientOriginalExtension();
                    $request->file('company_logo')->move(public_path('uploads/company_logo/'), $company_logo);
                    $user->city = $company_logo;
                }
                $user->save();
                if($user->id){
                    Session::flash('status', 'success');
                    if(!empty($request->id)){
                        \Session::flash('success', 'Customer Successfully Updated.');
                        $return['success'] = 'success';
                    } else {
                        \Session::flash('success', 'Customer Successfully Created.');
                        $return['success'] = 'success';
                    }
                }
                print json_encode($return);
                exit;
            } else {
                $return['errors'] = $validator->errors()->all();
                print json_encode($return);
                exit;
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            return response()->json(['error' => true, 'message' => trans('users/message.user_not_found')]);
        }
    }
}
