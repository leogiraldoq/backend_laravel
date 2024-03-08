<?php

namespace App\Interfaces;

interface DeliveryRepositoryInterface {
    public function save($deliveryData,$userId);
    
}
