<?php

namespace App\Interfaces;

interface UsersRepositoryInterface
{
    public function listAll();
    public function query($id);
    public function create($employeeId,$username,$namesEmployee,$emailEmployee);
    public function update($updateUser);
    public function changeStatus($changeStatusUser,$id);
    public function updateLastLogin($idUser);
    public function updateNewPassword($idUser,$password);
    public function forgotPassword($mailUser,$username);
}