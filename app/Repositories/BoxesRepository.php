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
    public function listAllByProduct($idProduct){
        return Boxes::where('product_id',listAllByProduct($idProduct))->get();
    }
    
    public function listAllWithProducts(){
        return Boxes::with(['products'])->get();
    }
    
    public function create($newBox){
        return Boxes::create([
            'dimensions' => $newBox['dimensions'],
            'product_id' => $newBox['productId']['id_product'],
            'active' => true
        ]);
    }
    
    public function resumeBoxProd($idBox){
        $boxProd = Boxes::with(['products'])->where('id_box',$idBox)->get();
        $order = array();
        $order['id_product'] = $boxProd['products']['id_product'];
        $order['id_box'] = $boxProd['id_box'];
        $order['product_name'] = $boxProd['products']['name'];
        $order['box_dimension'] = $boxProd['dimensions'];
        $order['box_active'] = $boxProd['active'];
        return $order;
    }
}