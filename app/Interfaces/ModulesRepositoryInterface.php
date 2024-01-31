<?php

namespace App\Interfaces;


interface ModulesRepositoryInterface{
    
    public function showAll();
    public function create($newModule);
}
