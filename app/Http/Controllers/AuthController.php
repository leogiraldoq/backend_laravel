<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponseTrait;
    
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['login']]);
    }

    /**
     * Login Blue Star Packing
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        try{
            if(! $token = auth()->attempt($credentials)){
                return $this->responseError('Please check your login information',401);
            }
            return $this->responseWhitToken($token,auth()->factory()->getTTL() * 60);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Get the authenticated User.
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     * */
    public function me()
    {
        try{
            return $this->responseOk('User authenticated',auth()->user());
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }   
    }

    /**
     * User logout
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function logout()
    {
        try{
            auth()->logout();
            return $this->responseOk('Successfully logged out');
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }   
    }
}
