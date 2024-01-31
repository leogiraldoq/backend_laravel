<?php

namespace App\Repositories;

use App\Interfaces\ProcessingRepositoryInterface;
use \App\Models\Processing;

class ProcessingRepository implements ProcessingRepositoryInterface
{
    /**
     * Create process merchansing
     * @param Object $processData Object with the element style number, style color, style total
     * @param Integer $userId User id that make the processing
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($processData,$userId){
        foreach($processData['stylesProcess'] as $process){
            Processing::create([
                "pre_bill_id" => $processData['preBillId'],
                "style_number" => $process['id'],
                "style_color" => $process['color'],
                "style_total" => $process['quantity'],
                "user_id" => $userId
            ]);
        }
        return $this->showPreBillingId($processData['preBillId']);
    }
    
    /**
     * Show all the process by pre billing id
     * @param Integer $preBillId Pre billing id
     * @return Array Result from query
     * @author LeoGiraldoQ
     */
    public function showPreBillingId($preBillId){
        return Processing::with(['pre_billing','users'])->where('pre_bill_id',$preBillId)->get()->toArray();
    }
}
