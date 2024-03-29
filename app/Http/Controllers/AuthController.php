<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Interfaces\UsersRepositoryInterface;
use App\Interfaces\EmployeesRepositoryInterface;

class AuthController extends Controller
{
    use ResponseTrait;
    private UsersRepositoryInterface $usersRepository;
    private EmployeesRepositoryInterface $employeRepository;
    
    public function __construct(UsersRepositoryInterface $usersRepository,EmployeesRepositoryInterface $employeRepository)
    {
        $this->middleware('auth:api',['except' => ['login']]);
        $this->usersRepository = $usersRepository;
        $this->employeRepository = $employeRepository;
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
            if(auth()->user()->active){
                $routeRedirect = "dashboard";
                if(auth()->user()->last_loguin == null){
                    $routeRedirect = "reset-password";
                }
                $this->usersRepository->updateLastLogin(auth()->user()->id_user);
                return $this->responseWhitToken($token,auth()->factory()->getTTL() * 60,$routeRedirect);
            }else{
                return $this->responseError("The user ".$credentials['username']. " is inactive!",404);
            }
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
            $user = auth()->user();
            $employee = $this->employeRepository->query($user['employee_id']);
            $user['nameEmploye'] = $employee['names']." ".$employee['last_names'];
            return $this->responseOk('User authenticated',$user);
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
