<?php

namespace App\Repositories;

use App\Interfaces\BoxesRepositoryInterface;
use App\Models\Boxes;

class BoxesRepository implements BoxesRepositoryInterface{
    /**
     * List all boxes options to receive
     * @return Model
     * @author LeoGiraldoQ
     */
    public function listAll(){
        return Boxes::all();
    }
    
    public function create($newBox){
        return Boxes::create([
            'describe' => $newBox['describe'],
            'dimensions' => $newBox['dimensions'],
            'active' => true
        ]);
    }
}