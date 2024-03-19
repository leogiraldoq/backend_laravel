<?php

namespace App\Repositories;
use App\Interfaces\ProductsRepositoryInterface;
use App\Models\Products;

/**
 * Description of ProductsRepository
 *
 * @author LeoGiraldoQ
 */
class ProductsRepository implements ProductsRepositoryInterface {
    
    public function show() {
        return Products::where('active',true)->get();
    }
    
    public function showWithBoxes(){
        return Products::with(['boxes'])->where('active',true)->get();
    }
    
    public function queryByBoxes(){
        $products = Products::with(['boxes'])->get();
        $listProductBoxes = array();
        foreach($products as $product){
            if(sizeof($product['boxes']) > 0){
                foreach($product['boxes'] as $box){
                    $order['id_product'] = $product['id_product'];
                    $order['id_box'] = $box['id_box'];
                    $order['product_name'] = $product['name'];
                    $order['box_dimension'] = $box['dimensions'];
                    $order['box_active'] = $box['active'];
                    $order['product'] = $product;
                    array_push($listProductBoxes,$order);
                }                
            } else {
                $order['id_product'] = $product['id_product'];
                $order['id_box'] = null;
                $order['product_name'] = $product['name'];
                $order['box_dimension'] = "N/A";
                $order['box_active'] = $product['active'];
                $order['product'] = $product;
                array_push($listProductBoxes,$order);
            }
        }
        return $listProductBoxes;
    }
    
    public function create($product){
        return Products::create([
            "name" => $product
        ]);
    }
    
}
