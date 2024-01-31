<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Repositories;
use App\Interfaces\RelProfileModuleRepositoryInterface;
use App\Models\RelProfileModule;

/**
 * Description of RelProfileModuleRepository
 *
 * @author LeoGiraldoQ
 */
class RelProfileModuleRepository implements RelProfileModuleRepositoryInterface{
    
    /**
     * Create the relation between profile and module
     * @param Object $newRelProfileModule
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($idProfile,$newRelProfileModule){
        foreach($newRelProfileModule as $key => $value){
            RelProfileModule::create([
                'profile_id' => $idProfile,
                'module_id' => $value['id_module'],
                'read' => $value['read'],
                'create' => $value['create'],
                'update' => $value['update'],
                'delete' => $value['erase']
            ]);
        }
        return $this->listPerProfile($idProfile);
    }
    
    /**
     * List the relation between profile and module filtering by profile id
     * @param Integer $idProfile
     * @return Model
     * @author LeoGiraldoQ
     */
    public function listPerProfile($idProfile){
        return RelProfileModule::where('profile_id',$idProfile)->get()->toArray();
    }
}
