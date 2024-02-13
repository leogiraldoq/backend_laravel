<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Interfaces\UsersRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //Traits
    use ResponseTrait;

    //Repositories
    private UsersRepositoryInterface $userRepository;

    public function __construct(
        UsersRepositoryInterface $userRepository
    ){
        $this->userRepository = $userRepository;
    }

    /**
     * List all User
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function list(){
        try{
            $users = $this->userRepository->listAll();
            return $this->responseOk('All users list',$users);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * List one User
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function show($id){
        try{
            $user = $this->userRepository->query($id);
            return $this->responseOk("User ".$user['username']." return",$user);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Create User
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(CreateUserRequest $request){
        try{
            $newUser = $request->validated();
            $user = $this->userRepository->create($newUser);
            return $this->responseOk("User ".$user['username']." create", $user);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * Update User
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function update(UpdateUserRequest $request){
        try{
            $updateUser = $request->validated();
            if($updateUser['current_password'] === $updateUser['new_password']){
                return $this->responseError("The new password dont be equal at the current password",401);
            }elseif($updateUser['new_password'] === $updateUser['new_password_confirmation']){
                $user = $this->userRepository->update($updateUser);
                return $this->responseOk("User ".$user['username']." was update", $user);
            }else{
                return $this->responseError("The new password and the confirmation new password dont match",401);
            }
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Change status active User
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function changeStatus(Request $request , int $id){
        try{
            $changeStatusUser = $request->validate([
                "active" => "boolean|required"
            ]);
            $user = $this->userRepository->changeStatus($request->input('active'),$id);
            return $this->responseOk("User ".$user['username']." was change status
            ", $user);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }
    
    /**
     * Update new password
     * @param Request $request Object passwordA and passwordRe
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function changePassword(Request $request){
        try{
            $changePassword = $request->validate([
                "passwordA" => "string|required|min:6",
                "passwordRe" => "string|required|min:6",
            ]);
            if( $changePassword["passwordA"] !== $changePassword["passwordRe"]){
                return $this->responseError("The passwords not match", 404);
            }else{
                $user = $this->userRepository->updateNewPassword(auth()->user()->id_user, $changePassword["passwordRe"]);
                return $this->responseOk("The password has been change for the user ".$user['username']);
            }
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }
    
    /**
     * Forgot password
     * @param Request $request email
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function forgotPassword(Request $request){
        try{
            $validate = $request->validate([
                "email" => "required|email",
                "username" => "string|required|min:4",
            ]);
            $user = $this->userRepository->forgotPassword($validate['email'],$validate['username']);
            return $this->responseOk("Thank you ".$user['employee']['names']." ".$user['employee']['last_names']." your password was restore, you receibe an email with intructions to accees");
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        } 
    }
    
}
