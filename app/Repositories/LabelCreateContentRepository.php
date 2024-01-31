<?php

namespace App\Repositories;

use App\Interfaces\LabelCreateContentRepositoryInterface;
use App\Models\LabelsCreateContent;

class LabelCreateContentRepository implements LabelCreateContentRepositoryInterface{
    
    /**
     * List all Label contents
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryAllActive() {
        return LabelsCreateContent::where('active',true)->get();
    }
    
    /**
     * Create Label contents
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newLabelContent){
        return LabelsCreateContent::create([
            'title_content' => $newLabelContent['titleLabelContent'],
            'list_contents' => json_encode($newLabelContent['contentLabel']),
        ]);
    }
}
