<?php

namespace App\Interfaces;

interface ProductsRepositoryInterface {
    public function show();
    public function showWithBoxes();
    public function queryByBoxes();
    public function create($product);
}
