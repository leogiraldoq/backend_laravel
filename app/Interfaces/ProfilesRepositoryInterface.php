<?php

namespace App\Interfaces;

interface ProfilesRepositoryInterface{
    
    public function showAll();
    public function create($newData);
    public function showUsersProfile($module);
    public function showMenuUser($idUser);
    public function index($idProfile);
    public function update($profile);
}
