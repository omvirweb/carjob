<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Hash;
use URL;
use Auth;
use Redirect;
use App\Models\User;

class FrontEndController extends Controller
{
    /**
     * Account sign in.
     *
     * @return View
     */
    public function getLogin()
    {
        // Is the user logged in?
        if ($user = Auth::user()) {
            return Redirect::route('dashboard');
        }
        
        // Show the page
        return view('login');
    }

    /**
     * Account sign in form processing.
     * @param Request $request
     * @return Redirect
     */
    public function postLogin(Request $request)
    {

        try {
            $remember = $request->remember;
            $credentials = array(
                'email' => $request->email,
                'role' => [User::ROLE_ADMIN, User::ROLE_USER, User::ROLE_DISTRIBUTOR],
                'password' => $request->password,
                'isActive' => '0'
            );

            if (Auth::attempt($credentials,$remember)) {

                $user = Auth::user();
                //dd($user);
                if($user->role == 'Admin'){
                    return redirect('admin/dashboard')->with('success', 'Login successfully');
                }else{
                    return redirect('home')->with('success', 'Login successfully');
                }
            } else {
                 return redirect('login')->with('success', 'Account not found');
            }
        } catch (NotActivatedException $e) {
             return redirect('login')->with('success', 'Account not activated');
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
             return redirect('login')->with('success', 'Account suspended', compact('delay'));

        }

    }

    public function getLogout()
    {
        if ($user = Auth::user()) {
            
            Auth::logout();
        }
        // Redirect to the users page
        return redirect('login')->with('success', 'You have successfully logged out!');
    }

}
