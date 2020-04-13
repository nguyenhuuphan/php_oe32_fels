<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Custom Logout function using Ajax
     * 
     * @return void
     */
    public function logout(Request $request)
    {
        if ($request->session()->has('result')) {
            $request->session()->flash('message', 'You\'re taking the lesson of ' . $request->user()->course()->first()->name . '. Please End Lesson to Logout!');
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'url' => route('course.lesson', $request->user()->course_id),
                ]);
            }
        } else {
            $this->guard()->logout();
            $request->session()->invalidate();
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'url' => route('login'),
                ]);
            }
        }
    }
}
