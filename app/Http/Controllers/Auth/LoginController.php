<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function authenticate(Request $request){
        $credentials = $request->only('email', 'password');

        try{
            if(!$token = $this->guard()->attempt($credentials)){
                return $this->response([
                    'message' => 'User credentials are not correct',
                    'error' => 'User credentials are not correct'], 401);
            }
        }catch(JWTException $e){
            return $this->response([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }

        return $this->response(compact('token'), 200);
    }

    public function getUserFromToken() {
        try{
            $user = $this->guard()->user();
            return $user;
        }
        catch (JWTException $e){
            return $this->response(['message' => 'Unable to retrieve user.',
                'error' => $e->getMessage()], 500);
        }
    }
}
