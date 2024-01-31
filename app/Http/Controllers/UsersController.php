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
}
