<?php

namespace App\Interfaces;

interface RelPackStoreRepositoryInterface {
    public function create($packId,$stores);
    public function showReceiveDetailsId($idREceiveDatils);
}
