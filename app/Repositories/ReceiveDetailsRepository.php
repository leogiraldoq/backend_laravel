<?php

namespace App\Repositories;

use App\Interfaces\ReceiveDetailsRepositoryInterface;
use App\Models\ReceiveDetails;
use Carbon\Carbon;
use App\Interfaces\RelBoutiquesCustomerInstructionsRepositoryInterface;
use App\Interfaces\ProcessingRepositoryInterface;

class ReceiveDetailsRepository implements ReceiveDetailsRepositoryInterface{
    
    private RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiquyeIntructionsRepository;
    private ProcessingRepositoryInterface $processingRepository;
    
    public function __construct(
            RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiquyeIntructionsRepository,
            ProcessingRepositoryInterface $processingRepository
        ) {
        $this->relBoutiquyeIntructionsRepository = $relBoutiquyeIntructionsRepository;
        $this->processingRepository = $processingRepository;
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
            'receive.user.employee'
        ])->orderBy('created_at', 'desc')->get();
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
            'boutiques.relBoutiqueCustomerInstructions',
            'boxes',
            'boxes.products',
            'receive',
            'receive.shipper',
            'receive.customer',
            'receive.customer.pick_up_company',
            'receive.user',
            'receive.user.employee',
            'pre_billing',
            'pre_billing.processing',
            'pre_billing.users.employee',
            'quality',
            'quality.user.employee'
        ])->where('id_receive_detail',$id)->get()->toArray();
    }
}