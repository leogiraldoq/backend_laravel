<?php

namespace App\Interfaces;


interface ShippersRepositoryInterface{
    public function listAll();
    public function create($newShop);
    public function listProcess($idCustomer);
    public function update($shipper);
    public function changeStatus($idShipper,$status);
    
}