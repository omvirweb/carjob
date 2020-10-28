<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use View;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;

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
        $allCountry = Countries::all();
        $userDetails = User::find(\Auth::user()->id);
        return view('admin.Users.profile', compact('allCountry', 'userDetails'));
    }

    public function updateProfile(Request $request)
    {

        try {
            $users = User::find($request->eid);
            $users->first_name = $request->firstName;
            $users->last_name = $request->lastName;
            $users->phone = $request->phoneNumber;
            $users->dob = $request->dob;
            $users->bio = $request->bio;
            $users->gender = $request->gender;
            $users->country = $request->countries;
            $users->state = $request->state;
            $users->city = $request->city;
            $users->address = $request->address;
            $users->postal = $request->postal;
            $users->save();

            return response()->json(['error' => false, 'message' => trans('users/message.success.update')]);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            return response()->json(['error' => true, 'message' => trans('users/message.user_not_found')]);
        }
    }
}
