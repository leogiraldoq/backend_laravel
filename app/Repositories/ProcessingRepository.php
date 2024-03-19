<?php

namespace App\Repositories;

use App\Interfaces\ProcessingRepositoryInterface;
use App\Interfaces\PreBillingRepositoryInterface;
use App\Interfaces\RelProcessAddWorkRepositoryInterface;
use \App\Models\Processing;
use Carbon\Carbon;

class ProcessingRepository implements ProcessingRepositoryInterface
{
    
    private PreBillingRepositoryInterface $preBillRepository;
    private RelProcessAddWorkRepositoryInterface $relProcessAddWork;
    
    public function __construct(
            PreBillingRepositoryInterface $preBillRepository,
            RelProcessAddWorkRepositoryInterface $relProcessAddWork
        ) {
        $this->preBillRepository = $preBillRepository;
        $this->relProcessAddWork = $relProcessAddWork;
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
                $processingIds[] = Processing::create([
                    "pre_bill_id" => $validateProcess['data']['preBillId'],
                    "style_number" => $process['id'],
                    "style_color" => ($validateProcess['data']['shareWork'] ? $process['color']['name'] : null),
                    "style_total" => $process['quantity'],
                    "set" => $process['set'],
                    "work_share" => $validateProcess['data']['shareWork'],
                    "user_id" => $userId
                ])->id_process;
            }
            $relProcess = $this->relProcessAddWork->create($processingIds, $processData['workAdd']);
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
        return Processing::with(['pre_billing','users','users.employee','rel_process_add_work','rel_process_add_work.process_add_work'])->where('pre_bill_id',$preBillId)->get()->toArray();
    }
    
    public function showUserId($userId){
        return Processing::with([
            'pre_billing',
            'pre_billing.receive_details',
            'pre_billing.receive_details.boutiques',
            'pre_billing.receive_details.boutiques.costumer',
            'pre_billing.receive_details.receive',
            'pre_billing.receive_details.receive.shipper',
            'rel_process_add_work',
            'rel_process_add_work.process_add_work'
        ])->where('user_id',$userId)->get()->toArray();
    }
    
    public function showUserIdDates($userId,$from,$to){
        return Processing::with([
            'pre_billing',
            'pre_billing.receive_details',
            'pre_billing.receive_details.boutiques',
            'pre_billing.receive_details.boutiques.costumer',
            'pre_billing.receive_details.receive',
            'pre_billing.receive_details.receive.shipper',
            'rel_process_add_work',
            'rel_process_add_work.process_add_work'
        ])->whereBetween('created_at', [$from, $to])->where('user_id',$userId)->get()->toArray();
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
    
    
    private function sumProceesStyles($idPreBill){
        $totalQnty = Processing::where([
            ['pre_bill_id','=',$idPreBill],
            ['work_share','=',true]
        ])->selectRaw('SUM(style_total) as totalQnty')->groupBy('pre_bill_id')->get()->toArray();
        return (sizeof($totalQnty) == 0 ? 0 : $totalQnty['totalQnty']);
    }
    
    public function resumeProcessing($preBillId){
        $processingResult = $this->showPreBillingId($preBillId);
        $processinResume = array();
        $processinResume['process'] = true;
        $processinResume['resume'] = array();
        $processinResume['total'] = 0;
        $totalProcessing = 0;
        $total = 0;
        if(sizeof($processingResult) > 0){
            foreach($processingResult as $process){
                $addWork = null;
                if(sizeof($process['rel_process_add_work']) > 0){
                    $work = array();
                    foreach($process['rel_process_add_work'] as $add){
                        array_push($work,$add['process_add_work']['name']);
                    }
                    $addWork = implode(", ",$work);
                }
                $totalProcessing = $totalProcessing + $process['style_total'];
                array_push($processinResume['resume'],[
                    "idProcess" => $process['id_process'],
                    "styleId" => $process['style_number'],
                    "styleColor" => ($process['style_color'] == null ? "N/A" : $process['style_color']),
                    "stylePieces" => $process['style_total'],
                    "styleSet" => $process['set'].' pieces',
                    "workShare" => ($process['work_share'] ? "Share" : "No share"),
                    "madeFor" => $process['users']['employee']['names'].' '.$process['users']['employee']['last_names'],
                    "total" => ($process['style_total']*$process['set']),
                    "q" => 0,
                    "addWork" => ($addWork !== null ? $addWork : "No add work")
                ]);
                $processinResume['total'] = $processinResume['total'] + ($process['style_total']*$process['set']);
            }
            if($processingResult[0]['pre_billing']['total_pieces'] == $totalProcessing){
                $processinResume['process'] = false;
            }            
        }
        return $processinResume;
    }
    
    public function resumeProcessingUserDate($userId,$from,$to){
        $processingResult = $this->showUserIdDates($userId,$from." 00:00:00", $to." 23:59:59");
        return $this->orderDataResume($processingResult);
    }
    
    public function resumeProcessingUser($userId){
        $processingResult = $this->showUserId($userId);
        return $this->orderDataResume($processingResult);
    }

    private function orderDataResume($processingResult){
        $costMano = 0.50;
        $processinResume = array();
        $processinResume['resume'] = array();
        $processinResume['total'] = 0;
        $processinResume['totalCost'] = 0;
        $processinResume['totalCustomers'] = 0;
        $processinResume['totalStores'] = 0;
        $customerArray = array();
        $storesArray = array();
        if(sizeof($processingResult) > 0){
            $processinResume['from'] = Carbon::parse($processingResult[0]['created_at'])->format('M d Y');
            foreach($processingResult as $process){
                $addWork = null;
                if(sizeof($process['rel_process_add_work']) > 0){
                    $work = array();
                    $costAddWork = 0;
                    foreach($process['rel_process_add_work'] as $add){
                        array_push($work,$add['process_add_work']['name']);
                        $costAddWork = $costAddWork+$add['process_add_work']['cost'];
                    }
                    $addWork = implode(", ",$work);
                }
                $totalPieces = $process['style_total']*$process['set'];
                $totalCost = $this->calculateCostProcessing($process['style_total'],$process['set'], $costMano, $costAddWork);
                array_push($processinResume['resume'],[
                    "idProcess" => $process['id_process'],
                    "styleId" => $process['style_number'],
                    "styleColor" => ($process['style_color'] == null ? "N/A" : $process['style_color']),
                    "stylePieces" => $process['style_total'],
                    "styleSet" => $process['set'].' pieces',
                    "workShare" => ($process['work_share'] ? "Share" : "No share"),
                    "total" => $totalPieces,
                    "addWork" => ($addWork !== null ? $addWork : "No add work"),
                    "customer" => $process['pre_billing']['receive_details']['boutiques']['costumer']['name'],
                    "boutique" => $process['pre_billing']['receive_details']['boutiques']['name'],
                    "store" => $process['pre_billing']['receive_details']['receive']['shipper']['name'],
                    "cost" => $totalCost,
                    "date" => Carbon::parse($process['created_at'])->format('M d Y g:i A'),
                ]);
                array_push($customerArray,$process['pre_billing']['receive_details']['boutiques']['costumer']['name']);
                array_push($storesArray,$process['pre_billing']['receive_details']['receive']['shipper']['name']);
                $processinResume['total'] = $processinResume['total'] + $totalPieces;
                $processinResume['to'] = Carbon::parse($process['created_at'])->format('M d Y');
                $processinResume['totalCost'] = $processinResume['totalCost']+$totalCost;
                 
            }
            $processinResume['totalCustomers'] = sizeof(array_count_values($customerArray));
            $processinResume['totalStores'] = sizeof(array_count_values($storesArray));
        }
        return $processinResume;

    }
    
    private function calculateCostProcessing($totalPieces,$set,$cost,$costAddWork){
        $totalPiecesSet = $totalPieces*$set;
        $totalCost = $cost+$costAddWork;
        return $totalPiecesSet*$totalCost;
    }
    
}
