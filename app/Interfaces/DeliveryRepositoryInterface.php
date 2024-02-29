<?php

namespace App\Interfaces;

interface DeliveryRepositoryInterface {
    public function create($deliveryData,$userId);
}
