<?php

namespace App\Repositories;

use App\Interfaces\PreBillingRepositoryInterface;
use App\Models\PreBilling;

class PreBillingRepository implements PreBillingRepositoryInterface{
    
    /**
     * Create pre billing 
     * @param Array $preBillData Array whit the invoice number, total pieces and receive details id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($preBillData,$userId){
        return PreBilling::create([
            "receive_details_id" => $preBillData['receiveDetailId'],
            "invoice_number" => $preBillData['invoiceNumber'],
            "quantity_styles" => $preBillData['invoicesQuantityStyles'],
            "total_pieces" => $preBillData['invoicesTotal'],
            "photo_invoice" => $preBillData['invoicesDocument'],
            "user_id" => $userId
        ]);
    }
    
    /**
     * All the invoice per receive details id
     * @param Integer $idReceiveDetails Id de la table receive_details
     * @return Model
     * @author LeoGiraldoQ
     */
    public function show($idReceiveDeteails){
        return PreBilling::with(['receive_details'])->where('receive_details_id',$idReceiveDeteails)->get();
    }
    
    /**
     * Return the total pieces per invoice
     * @param Integer $idPreBill Id for the table pre_billing
     * @return Integer Total quantity of pieces in the invoice pre billing
     * @author LeoGiraldoQ
     */
    public function totalPiecesInvoice($idPreBill){
        return PreBilling::find($idPreBill)->getAttribute('total_pieces');
    }
}
