<?php

namespace App\Interfaces;

interface ProfilesRepositoryInterface{
    
    public function showAll();
    public function create($newData);
    public function update($updateData);
    public function showUsersProfile($module);
    
}
