<?php

namespace App\Repositories;

use \App\Interfaces\ModulesRepositoryInterface;
use \App\Models\Modules;

class ModulesRepository implements ModulesRepositoryInterface{
    
    /**
     * Query all modules
     * @return Model
     * @author LeoGiraldoQ
     */
    public function showAll(){
        return Modules::all();
    }

    /**
     * Create new modules
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newModule){
        return Modules::create([
            'module_name' => $newModule['module_name'],
            'description' => $newModule['description']
        ]);
    }
}