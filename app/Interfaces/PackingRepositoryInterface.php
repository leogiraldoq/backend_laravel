<?php

namespace App\Interfaces;

interface PackingRepositoryInterface {
    public function createPrepareSend($prepareData,$userId);
    public function customerToDelivery();
    public function toDeliveryPerCustomer($idCustomer);
}
