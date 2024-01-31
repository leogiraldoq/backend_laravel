<?php

namespace App\Repositories;

use App\Interfaces\LabelsRepositoryInterface;
use App\Models\Labels;

class LabelsRepository implements LabelsRepositoryInterface{
    
    /**
     * Create labels for customer
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newLabels,$idCustomer){
        return Labels::create([
            "customer_id" => $idCustomer,
            "name" => $newLabels['nameLabel'],
            "quantity" => $newLabels['quantity'],
            "sample_image" => $newLabels['imageSample']
        ]);
    }

}