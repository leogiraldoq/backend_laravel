<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Repositories;
use App\Interfaces\DeliveryRepositoryInterface;
use App\Models\Delivery;

/**
 * Description of DeliveryRepository
 *
 * @author LeoGiraldoQ
 */
class DeliveryRepository implements DeliveryRepositoryInterface{
    
    public function create($deliveryData,$userId){
        return Delivery::create([
            "names" => $deliveryData['nameRecipiet'],
            "pickup_id" => $deliveryData['pickUpId'],
            "user_id" => $userId,
            "photo" => $deliveryData['photoReceipt'],
            "signature" => $deliveryData['signatureReceipt'],
            "ticket" => $deliveryData['ticket']
        ]);
    }
    
    
}
