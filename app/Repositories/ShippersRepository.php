<?php

namespace App\Repositories;
use App\Interfaces\ShippersRepositoryInterface;
use App\Models\Shippers;

class ShippersRepository implements ShippersRepositoryInterface{
    
    /**
     * List all shippers
     * @return Model
     * @author LeoGiraldoQ
     */
    public function listAll(){
        return Shippers::all();
    }
    
    public function index($idShipper){
        return Shippers::find($idShipper);
    }
    /**
     * List all shippers
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newShop){
        return Shippers::create([
            'name' => $newShop['name'],
            'contact_name' => $newShop['contactName'],
            'contact_number' => $newShop['contactNumber'],
            'email' => $newShop['email'],
            'active' => 1
        ]);
    }
    
    /**
     * List all shippers that process with customer
     * @param Integer $idCustomer Customer Id
     */
    public function listProcess($idCustomer){
        return Shippers::whereDoesntHave('customer_not_process',function($query) use ($idCustomer){
            $query->where('customer_id',$idCustomer);
        })->where('active',true)->get()->toArray();
    }
    
    public function update($shipper){
        $storeUpdate = Shippers::where('id_shipper',$shipper['id'])->update([
            'name' => $shipper['name'],
            'contact_name' => $shipper['contactName'],
            'contact_number' => $shipper['contactNumber'],
            'email' => $shipper['email'],
        ]);
        
        return $this->index($shipper['id']);
    }
    
    public function changeStatus($idShipper,$status){
        $storeUpdate = Shippers::where('id_shipper',$idShipper)->update([
            'active' => $status
        ]);
        return $this->index($idShipper);
    }
}