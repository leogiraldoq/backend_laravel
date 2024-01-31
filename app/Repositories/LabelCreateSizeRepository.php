<?php

namespace App\Repositories;

use App\Interfaces\LabelCreateSizeRepositoryInterface;
use App\Models\LabelsCreateSize;

class LabelCreateSizeRepository implements LabelCreateSizeRepositoryInterface{
    
    /**
     * List all Label size
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryAllActive(){
        return LabelsCreateSize::where('active',true)->get();
    }
    
    /**
     * Create all Label size
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newLabelSize){
        return LabelsCreateSize::create([
            'title_label_size' => $newLabelSize['titleSize'],
            'list_size' => json_encode($newLabelSize['listLabelSize']),
        ]);
    }
}