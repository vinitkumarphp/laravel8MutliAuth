<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class AdminController extends Controller
{


    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $credential=$request->only('email','password');
        if(Auth::guard('admin')->attempt($credential,$request->remember)){
            $user=Admin::where('email',$request->email)->first();
            Auth::guard('admin')->login($user);
            return redirect()->route('admin.home');
        }
        return redirect()->route('admin.login')->with('status','failed to proccess login');

    }



    public function logout(Request $request)
    {

        $this->guard()->logout();
        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

      /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
