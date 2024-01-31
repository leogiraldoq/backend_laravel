<?php

namespace App\Interfaces;

interface LabelCreateSizeRepositoryInterface{
    public function queryAllActive();
    public function create($newLabelSize);
    
}

