<?php

namespace App\Repositories;

use App\Interfaces\ProcessingRepositoryInterface;
use App\Interfaces\PreBillingRepositoryInterface;
use \App\Models\Processing;

class ProcessingRepository implements ProcessingRepositoryInterface
{
    
    private PreBillingRepositoryInterface $preBillRepository;
    
    public function __construct(PreBillingRepositoryInterface $preBillRepository) {
        $this->preBillRepository = $preBillRepository;
    }
    
    /**
     * Create process merchansing
     * @param Object $processData Object with the element style number, style color, style total
     * @param Integer $userId User id that make the processing
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($processData,$userId){
        $validateProcess = $this->validateData($processData);
        if($validateProcess['error']){
            return $validateProcess;
        }else{
            foreach($validateProcess['data']['stylesProcess'] as $process){
                Processing::create([
                    "pre_bill_id" => $validateProcess['data']['preBillId'],
                    "style_number" => $process['id'],
                    "style_color" => $process['color']['name'],
                    "style_total" => $process['quantity'],
                    "work_share" => $validateProcess['data']['shareWork'],
                    "user_id" => $userId
                ]);
            }
            return [
                "error" => false,
                "data" => $this->showPreBillingId($processData['preBillId'])
            ];

            
            
        }
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
    
    /**
     * Validate the information in the processing
     */
    public function validateData($process){
        $totalQuantity = $this->preBillRepository->totalPiecesInvoice($process["preBillId"]);
        $totalProcess = 0;
        if($process['shareWork']){
            $totalProcess = $this->sumProceesStyles($process["preBillId"]);
        }
        foreach($process['stylesProcess'] as $style){
            $totalProcess += $style['quantity'];
        }
        if($totalQuantity < $totalProcess){
            return [
                "message" => "The total pieces that you process its <b>MAYOR</b> that the pieces in the invoice, you enter <b>".$totalProcess."</b> pieces and the invoice said <b>".$totalQuantity."</b> pieces in total. Check the information or contact the manager.",
                "code" => 422,
                "error" => true,
                "data" => null
            ];
        }elseif($totalQuantity > $totalProcess && !$process['shareWork']){
            return [
                "message" => "The total pieces that you process its <b>MENOR</b> that the pieces in the invoice, you enter <b>".$totalProcess."</b> pieces and the invoice said <b>".$totalQuantity."</b> pieces in total. Check the information or contact the manager.",
                "code" => 422,
                "error" => true,
                "data" => null
            ];
        }else{
            return [
                "message" => "Data validated",
                "code" => 200,
                "error" => false,
                "data" => $process
            ]
            ;
        }
    }
    
    
    public function sumProceesStyles($idPreBill){
        $totalQnty = Processing::where([
            ['pre_bill_id','=',$idPreBill],
            ['work_share','=',true]
        ])->selectRaw('SUM(style_total) as totalQnty')->groupBy('pre_bill_id')->get()->toArray();
        return (sizeof($totalQnty) == 0 ? 0 : $totalQnty['totalQnty']);
    }
}
