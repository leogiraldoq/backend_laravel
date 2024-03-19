<?php
namespace App\Repositories;
use App\Interfaces\TrackingRepositoryInterface;
use App\Models\Costumers;
use App\Models\Boutiques;
use App\Models\Processing;
use App\Models\Users;
use Carbon\Carbon;
/**
 * Description of TrackingRepository
 *
 * @author LeoGiraldoQ
 */
class TrackingRepository implements TrackingRepositoryInterface{
    
    public function listAllProcess(){
        return Costumers::with([
            'boutiques',
            'boutiques.receive_details',
            'boutiques.receive_details.pre_billing',
            'boutiques.receive_details.pre_billing.processing',
            'boutiques.receive_details.pre_billing.processing.rel_process_add_work.process_add_work',
            'boutiques.receive_details.quality',
            'boutiques.packing',
            'boutiques.packing.rel_pack_delivery',
            'receive',
            'receive.shipper',
            'pick_up_company',
        ])->get();
    }
    
    public function showUserBill(){
        return Users::with([
            'employee',
            'processing.pre_billing.receive_details.boutiques.costumer',
            'processing.pre_billing.receive_details.receive.shipper',
            'processing.rel_process_add_work.process_add_work'
        ])->get()->toArray();
    }
    
    public function listBoutiqueProcess($idBoutique){
        return Boutiques::with([
            'receive_details',
            'receive_details.boxes.products',
            'receive_details.pre_billing.processing.rel_process_add_work.process_add_work',
            'receive_details.pre_billing.processing.users.employee',
            'receive_details.receive.shipper',
        ])->where("id_boutique",$idBoutique)->get();
    }
    
    public function generalResume(){
        $customersResumeAll = $this->listAllProcess();
        $dataReturn = array();
        foreach ($customersResumeAll as $customer){
            $data = array();
            $data['idCustomer'] = $customer['id_costumer'];
            $data['nameCustomer'] = $customer['name'];
            $data['pickUpCompany'] = $customer['pick_up_company']['name'];
            $data['boutique'] = array();
            $data['totalReceibing'] = 0;
            $data['totalPrebill'] = 0;
            $data['totalQuality'] = 0;
            $data['totalPacking'] = 0;
            $data['totalProcessing'] = 0;
            foreach($customer['boutiques'] as $boutiques){
                $d = array();
                $d['idBoutique'] = $boutiques['id_boutique'];
                $d['nameBoutique'] = $boutiques['name'];
                $d['totalReceibing'] = $boutiques['receive_details']->sum('quantity_box');
                $totalBps = $boutiques['receive_details']->map(function($item,$key){
                    return [
                        "preBill" => ($item['pre_billing'] !== null ? $item['pre_billing']->count() : 0),
                        "quality" => (sizeof($item['quality']) > 0 ? $item['quality']->count() : 0),
                        "collectionPreBill" => ($item['pre_billing'] !== null ? $item['pre_billing']->toArray() : null)
                        ];
                });
                $d['totalPrebill'] = $totalBps->sum("preBill");
                $d['totalQuality'] = $totalBps->sum("quality");
                $d['totalPacking'] = ($boutiques['packing'] !== null ? $boutiques['packing']->sum("quantity") : 0);
                foreach ($totalBps as $processing){
                    if($processing['collectionPreBill'] !== null){
                        $pieces = array_map(function($value){
                                return (sizeof($value) > 0 ? $value['style_total']*$value['set']:0);
                            },$processing['collectionPreBill']['processing']);
                        $d['totalProcessing'] = array_sum($pieces);
                    }else{
                        $d['totalProcessing'] = 0;
                    }
                }
                $data['totalReceibing'] = $data['totalReceibing']+$d['totalReceibing'];
                $data['totalPrebill'] = $data['totalPrebill']+$d['totalPrebill'];
                $data['totalQuality'] = $data['totalQuality']+$d['totalQuality'];
                $data['totalPacking'] = $data['totalPacking']+$d['totalPacking'];
                $data['totalProcessing'] = $data['totalProcessing']+$d['totalProcessing'];
                array_push($data['boutique'],$d);
            }
            array_push($dataReturn,$data);
        }
        return $dataReturn;
    }
    
    public function preBillProcessCustomerResume(){
        $customerALlData = $this->listAllProcess()->toArray();
        $costMano = 0.50;
        $dataReturn = array();
        foreach ($customerALlData as $customer){
            $data = array();
            $data['idCustomer'] = $customer['id_costumer'];
            $data['nameCustomer'] = $customer['name'];
            $data['boutique'] = array();
            foreach($customer['boutiques'] as $boutiques){
                $d = array();
                $d['idBoutique'] = $boutiques['id_boutique'];
                $d['nameBoutique'] = $boutiques['name'];
                $d['totalPreBillPieces'] = 0;
                $d['totalProcessPieces'] = 0;
                $d['totalProcessCharge'] = 0;
                foreach($boutiques['receive_details'] as $receibeDetails){
                    if ($receibeDetails['pre_billing'] !== null){
                        $d['totalPreBillPieces'] = $d['totalPreBillPieces'] + $receibeDetails['pre_billing']['total_pieces'];
                        if(sizeof($receibeDetails['pre_billing']['processing']) > 0 ){
                            $totalProcessPieces = 0;
                            foreach($receibeDetails['pre_billing']['processing'] as $processing){
                                $totalProcessPieces = $totalProcessPieces + ($processing['style_total']*$processing['set']);
                                $costAddWork = 0;
                                foreach($processing['rel_process_add_work'] as $addWork){
                                    $costAddWork = $costAddWork+$addWork['process_add_work']['cost'];
                                }
                                $d['totalProcessCharge'] = $d['totalProcessCharge'] + ($this->calculateCostProcessing($processing['style_total'], $processing['set'], $costMano, $costAddWork));
                            }
                            $d['totalProcessPieces'] = $totalProcessPieces;
                        }
                    }
                }       
                array_push($data['boutique'],$d);
                $data['totalPreBillPieces'] = 0;
                $data['totalProcessPieces'] = 0;
                $data['totalProcessCharge'] = 0;
                foreach($data['boutique'] as $sums){
                    $data['totalPreBillPieces'] = $data['totalPreBillPieces'] + $sums['totalPreBillPieces'];
                    $data['totalProcessPieces'] = $data['totalProcessPieces'] + $sums['totalProcessPieces'];
                    $data['totalProcessCharge'] = $data['totalProcessCharge'] + $sums['totalProcessCharge'];
                }
            }
            array_push($dataReturn,$data);
        }
        return $dataReturn;
    }
    
    public function preBillProcessBoutiqueDetails($idBoutique){
        $boutique = $this->listBoutiqueProcess($idBoutique)->toArray();
        $costMano = 0.50;
        $dataReturn = array();
        foreach($boutique as $b){
            $dataReturn['nameBoutique'] = $b['name'];
            $dataReturn['details'] = array();
            foreach($b['receive_details'] as $rD){
                $d = array();
                $d['receibeDetails'] = [
                    "idReceibeDetails" => $rD['id_receive_detail'],
                    "quantity" => $rD['quantity_box'],
                    "product" => $rD['boxes']['products']['name'],
                    "size" => $rD['boxes']['dimensions'],
                    "date" => Carbon::parse($rD['created_at'])->format('M d Y g:i A'),
                    "followNumber" => $rD['receive']['follow_number'],
                    "store" => $rD['receive']['shipper']['name']
                ];
                if($rD['pre_billing'] !== null){
                    $d['receibeDetails']['preBilling']["invoiceNumber"] = $rD['pre_billing']['invoice_number'];
                    $d['receibeDetails']['preBilling']["quantity"] = $rD['pre_billing']['total_pieces'];
                    $d['receibeDetails']['preBilling']["date"] = Carbon::parse($rD['created_at'])->format('M d Y g:i A');
                    $d['receibeDetails']['preBilling']["processing"] = array();
                    $d['receibeDetails']['preBilling']["totalCost"] = $rD['pre_billing']['total_pieces']*$costMano;
                    if(sizeof($rD['pre_billing']['processing']) > 0){
                        $totalPieces = 0;
                        $totalCostAddWork = 0;
                        foreach($rD['pre_billing']['processing'] as $processing){
                            $process = array();
                            $process["styleId"] = $processing['style_number'];
                            $process["numberStyle"] = $processing['style_total'];
                            $process["set"] = $processing['set'];
                            $process["date"] = Carbon::parse($processing['created_at'])->format('M d Y g:i A');
                            $process["totalSet"] = $processing['style_total']*$processing['set'];
                            $totalPieces = $totalPieces + $process["totalSet"];
                            $process["whodo"] = $processing['users']['employee']['names']." ".$processing['users']['employee']['last_names'];
                            $process["addWork"] = array();
                            $totalAddWork = 0;    
                            if(sizeof($processing["rel_process_add_work"]) > 0){
                                foreach($processing["rel_process_add_work"] as $addWork){
                                    array_push($process["addWork"],[
                                            "name" => $addWork['process_add_work']['name'],
                                            "cost" => $addWork['process_add_work']['cost']
                                    ]);
                                    $totalAddWork = $totalAddWork + $addWork['process_add_work']['cost'];
                                    error_log($totalCostAddWork);
                                }
                                $totalCostAddWork = $totalCostAddWork + $totalAddWork;
                            }
                            $process["addWork"]["totalCost"] = $totalAddWork;
                            $process["totalCostSetAdd"] = $process["totalSet"]*$process["addWork"]["totalCost"];
                            array_push($d["receibeDetails"]["preBilling"]["processing"],$process);
                        }
                        $d["receibeDetails"]["preBilling"]["processing"]["totalPieces"] = $totalPieces;
                        $d["receibeDetails"]["preBilling"]["processing"]["totalCostAddWork"] = $totalCostAddWork;
                        $d["receibeDetails"]["preBilling"]["processing"]["totalCost"] = ($totalCostAddWork > 0 ? ($totalPieces*$costMano)+($totalPieces*$totalCostAddWork) : ($totalPieces*$costMano));
                    }else{
                        $d["receibeDetails"]["preBilling"]["processing"]["totalPieces"] = 0;
                        $d["receibeDetails"]["preBilling"]["processing"]["totalCostAddWork"] = 0;
                        $d["receibeDetails"]["preBilling"]["processing"]["totalCost"] = 0;
                    }
                }else{
                    $d['receibeDetails']['preBilling']["invoiceNumber"] = "-";
                    $d['receibeDetails']['preBilling']["quantity"] = 0;
                    $d['receibeDetails']['preBilling']["date"] = "-";
                    $d['receibeDetails']['preBilling']["totalCost"] = 0;
                    $d['receibeDetails']['preBilling']["processing"] = array();
                    $d["receibeDetails"]["preBilling"]["processing"]["totalPieces"] = 0;
                    $d["receibeDetails"]["preBilling"]["processing"]["totalCostAddWork"] = 0;
                    $d["receibeDetails"]["preBilling"]["processing"]["totalCost"] = 0;
                }
                array_push($dataReturn['details'],$d);
            }
        }
        return $dataReturn;
    }
    
    public function showBillEmployee(){
        $processingResult = $this->showUserBill();
        $costMano = 0.50;
        $dataReturn = array();
        foreach($processingResult as $user){
            $perUser = array();
            $perUser["totalPieces"] = 0;
            $perUser["totalBill"] = 0;
            $perUser["idUser"] = $user["id_user"];
            $perUser["names"] = $user["employee"]["names"]." ".$user["employee"]["last_names"];
            $perUser["billResume"] = array();
            foreach($user["processing"] as $process){
                $pro = array();
                $pro["date"] = Carbon::parse($process['created_at'])->format('M d Y g:i A');
                $pro["idProcess"] =  $process["id_process"];
                $pro["styleId"] = $process["style_number"];
                $pro["pieces"] = $process["style_total"];
                $pro["set"] = $process["set"];
                $pro["totalPiecesSet"] = $process["style_total"]*$process["set"];
                $perUser["totalPieces"] = $perUser["totalPieces"] + $process["style_total"];
                $nameAddWork = array();
                $costAddWork = 0;
                foreach($process['rel_process_add_work'] as $addWork){
                    array_push($nameAddWork,$addWork['process_add_work']['name']);
                    $costAddWork = $costAddWork+$addWork['process_add_work']['cost'];
                }
                $pro["namesAddWork"] = (sizeof($nameAddWork) > 0 ? implode(", ",$nameAddWork) : "-");
                $pro["costAddWork"] = $costAddWork;
                $pro["totalToPay"] = $this->calculateCostProcessing($pro["pieces"],$pro["set"], $costMano, $costAddWork);
                $perUser["totalBill"] = $perUser["totalBill"] + $pro["totalToPay"];
                $pro["boutique"] = $process['pre_billing']['receive_details']['boutiques']['name'];
                $pro["customer"] = $process['pre_billing']['receive_details']['boutiques']['costumer']['name'];
                array_push($perUser["billResume"],$pro);
            }
            array_push($dataReturn,$perUser);
        }
        return $dataReturn;
    }
    
    private function calculateCostProcessing($totalPieces,$set,$cost,$costAddWork){
        $totalPiecesSet = $totalPieces*$set;
        $totalCost = $cost+$costAddWork;
        return $totalPiecesSet*$totalCost;
    }
}
