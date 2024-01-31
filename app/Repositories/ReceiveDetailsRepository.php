<?php

namespace App\Repositories;

use App\Interfaces\ReceiveDetailsRepositoryInterface;
use App\Models\ReceiveDetails;
use Carbon\Carbon;
use App\Interfaces\RelBoutiquesCustomerInstructionsRepositoryInterface;

class ReceiveDetailsRepository implements ReceiveDetailsRepositoryInterface{
    
    private RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiquyeIntructionsRepository;
    
    public function __construct(RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiquyeIntructionsRepository) {
        $this->relBoutiquyeIntructionsRepository = $relBoutiquyeIntructionsRepository;
    }
    /**
     * Create details for receive boxes
     * @param Object $newReceiveDetails Object with the data for create a receive detail
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newReceiveDetails){
        return ReceiveDetails::create([
            'receive_id' => $newReceiveDetails['receiveId'],
            'boutique_id' => $newReceiveDetails['boutique']['id_boutique'],
            'box_id' => $newReceiveDetails['box']['id_box'],
            'quantity_box' => $newReceiveDetails['quantity'],
            'weight_box' => $newReceiveDetails['weight']
        ]);
    }
    
    /**
     * Query for the receive details with receive, customers, users 
     * @param Date $date Date to filter in the query
     * @return Model Result for the query
     * @author LeoGiraldoQ
     */
    public function queryByDate($date){
        return ReceiveDetails::with([
            'boutiques',
            'boxes',
            'receive',
            'receive.shipper',
            'receive.customer',
            'receive.user',
            'receive.user.employee'
        ])->whereBetween('created_at', [$date.' 00:00:00', $date.' 23:59:59'])->get();
    }
    
    /**
     * Query for the receive details with receive, customers, users 
     * @param Integer $id Id for the receive
     * @return Model Result for the query
     * @author LeoGiraldoQ
     */
    public function queryByIdReceieving($id){
        return ReceiveDetails::with([
            'boutiques',
            'boxes',
            'receive',
            'receive.shipper',
            'receive.customer',
            'receive.user',
            'receive.user.employee'
        ])->where('receive_id', $id)->get()->toArray();
    }
    
    
    /**
     * Return data for the qr read in the pre-bill process
     * @param String $code Base 64 id receive_details
     * @return Array Array for the field that we need to show
     * @author LeoGiraldoQ
     */
    public function showQrPreBill($code){
        $receiveDetails = $this->show(base64_decode($code));
        $names = $receiveDetails[0]['receive']['user']['employee']['names'].' '.$receiveDetails[0]['receive']['user']['employee']['last_names'];
        $result = array(
            "received_date" => Carbon::parse($receiveDetails[0]['receive']['created_at'])->format('F d Y H:i:s'),
            "follow_number" => $receiveDetails[0]['receive']['follow_number'],
            "customer" => $receiveDetails[0]['receive']['customer']['name'],
            "boutique" => $receiveDetails[0]['boutiques']['name'],
            "store" => $receiveDetails[0]['receive']['shipper']['name'],
            "process" => $receiveDetails[0]['receive']['its_process'],
            "box_type" => $receiveDetails[0]['boxes']['describe'],
            "box_dimensions" => $receiveDetails[0]['boxes']['dimensions'],
            "box_quantity" => $receiveDetails[0]['quantity_box'],
            "box_weight" => $receiveDetails[0]['weight_box'],
            "receibed_by" => $names,
            "special_observations" => $receiveDetails[0]['receive']['observations'],
            "id_receive_details" => $receiveDetails[0]['id_receive_detail'],
            "id_receibed_user_id" => $receiveDetails[0]['receive']['user_id']
        );
        return $result;
        
    }
    
    /**
     * Return data for the qr read in the processing process
     * @param String $code Base 64 id receive_details
     * @return Array Array for the field that we need to show
     * @author LeoGiraldoQ
     */
    public function showQrProcessing($code){
        $receiveDetails = $this->show(base64_decode($code));
        $instructions = $this->relBoutiquyeIntructionsRepository->bringInstructiosPerBoutique($receiveDetails[0]['boutiques']['id_boutique']);
        $result = array(
            "customer" => $receiveDetails[0]['receive']['customer']['name'],
            "boutique" => $receiveDetails[0]['boutiques']['name'],
            "store" => $receiveDetails[0]['receive']['shipper']['name'],
            "invoiceNum" => ($receiveDetails[0]['pre_billing'] !== null ? $receiveDetails[0]['pre_billing']['invoice_number'] : null),
            "total" => ($receiveDetails[0]['pre_billing'] !== null ? $receiveDetails[0]['pre_billing']['total_pieces'] : null),
            "instructions" => (sizeof($instructions) > 0 ? json_decode($instructions[0]["rel_customer_intructions"]['instructions']) : null),
            "preBillId" => $receiveDetails[0]['pre_billing']['id_pre_bill']
        );
        return $result;
    }
    
    
    /**
     * Query for all receive details with receive, customers, users,shippers and boutiques
     * @return Model Result for the query
     * @author LeoGiraldoQ
     */
    public function showAll(){
        return ReceiveDetails::with([
            'boutiques',
            'boxes',
            'receive',
            'receive.shipper',
            'receive.customer',
            'receive.user',
            'receive.user.employee',
        ])->get();
    }
    
    /**
     * Query for one id receive details receive, customers, users,shippers and boutiques
     * @param Integer $id Id table receive_details
     * @return Array Result for the query
     * @author LeoGiraldoQ
     */
    public function show($id){
        return ReceiveDetails::with([
            'boutiques',
            'boxes',
            'receive',
            'receive.shipper',
            'receive.customer',
            'receive.user',
            'receive.user.employee',
            'pre_billing'
        ])->where('id_receive_detail',$id)->get()->toArray();
    }
}