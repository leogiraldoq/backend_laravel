<?php

namespace App\Repositories;

use App\Mail\UsersCreate;
use App\Mail\UserForgotPassword;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\Users;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersRepository implements UsersRepositoryInterface
{

    /**
     * List all User
     * @return Model
     * @author LeoGiraldoQ
     */
    public function listAll(){
        return Users::all();
    }

    /**
     * List one User
     * @param $id_user
     * @return Model
     * @author LeoGiraldoQ
     */
    public function query($id)
    {
        return Users::where('id_user',$id)->with(['employee'])->firstOrFail();
    }

    /**
     * Create User
     * @param Integer $employeeId Id for a employee to assign the user
     * @param String $username Username for auth in the platform
     * @return Model
     * @author LeoGiraldoQ
     */
     public function create($employeeId,$username,$namesEmployee,$emailEmployee)
     {
        $temporalyPassword = Str::random(8);
        $createUser = Users::create([
            "employee_id" => $employeeId,
            "username" => $username,
            "password" => Hash::make($temporalyPassword),
        ]);
        Mail::to($emailEmployee)->queue( new UsersCreate($namesEmployee,$username,$temporalyPassword));
        return $createUser;
        
     }

    /**
     * Update User
     * @param $updateUser
     * @return Model
     * @author LeoGiraldoQ
     */
    public function update($updateUser)
    {        
       $user = Users::where([
            'username' => $updateUser['username'],
            'password' => $updateUser['current_password'],
            'id_user' => $updateUser['userd']
        ])->firstOrFail();
        return tap($user)->update([
            "username" => $updateUser['username'],
            "password" => $updateUser['new_password_confirmation'],
        ]);
    }


    /**
     * Change status active User
     * @param $updateUser
     * @return Model
     * @author LeoGiraldoQ
     */
    public function changeStatus($changeStatusUser, $id)
    {
        $user = $this->query($id);
        return tap($user)->update([
            'active' => $changeStatusUser
        ]);
    }
    
    /**
     * Update Last Login
     * @param $updateUser
     * @return Model
     * @author LeoGiraldoQ
     */
    public function updateLastLogin($idUser)
    {        
       $user = Users::where([
            'id_user' => $idUser
        ])->firstOrFail();
        return tap($user)->update([
            "last_loguin" => Carbon::now()->toDateTimeString()
        ]);
    }
    
    /**
     * Update Last Login
     * @param $updateUser
     * @return Model
     * @author LeoGiraldoQ
    */
    public function updateNewPassword($idUser,$password){
        $user = Users::where([
            'id_user' => $idUser
        ])->firstOrFail();
        return tap($user)->update([
            "password" => Hash::make($password)
        ]);
    }
    
    public function forgotPassword($mailUser,$username){
        $user = Users::where('username','=',$username)->whereHas('employee',function($query) use ($mailUser){
            $query->where('email','=',$mailUser);
        })->with(['employee'])->firstOrFail();

        $provisionalPass = Str::random(8);
        tap($user)->update([
            "last_loguin" => null,
            "password" => Hash::make($provisionalPass)
        ]);   
        $namesEmployee = $user['employee']['names']." ".$user['employee']['last_names'];
        Mail::to($user['employee']['email'])->queue( new UserForgotPassword($namesEmployee,$user['username'],$provisionalPass));
        return $user;
    }
}