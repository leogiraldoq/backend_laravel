<?php

namespace App\Interfaces;

interface BoxesRepositoryInterface {
    public function listAllByProduct($idProduct);
    public function listAllWithProducts();
    public function create($newBox);
    public function resumeBoxProd($idBox);
}
