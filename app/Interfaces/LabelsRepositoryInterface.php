<?php

namespace App\Interfaces;

interface LabelsRepositoryInterface{
    
    public function create($newLabel,$idCustomer);
}