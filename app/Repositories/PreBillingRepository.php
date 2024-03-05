<?php

namespace App\Repositories;

use App\Interfaces\PreBillingRepositoryInterface;
use App\Models\PreBilling;
use Carbon\Carbon;

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
    
    public function listAll(){
        $preBill = PreBilling::with([
            'receive_details',
            'receive_details.boutiques',
            'receive_details.boxes',
            'receive_details.boxes.products',
            'receive_details.receive',
            'receive_details.receive.customer',
            'receive_details.receive.shipper',
            'receive_details.receive.user.employee',
        ])->get()->toArray();
        $resumePreBill = array();
        foreach ($preBill as $pb){
            array_push($resumePreBill, [
                'idPreBill' =>  $pb['id_pre_bill'],
                'invoiceNumber' => $pb['invoice_number'],
                'totalInvocePieces' => $pb['total_pieces'],
                'boutique' => $pb['receive_details']['boutiques']['name'],
                'totalBox' => $pb['receive_details']['quantity_box'],
                'customer' => $pb['receive_details']['receive']['customer']['name'],
                'store' => $pb['receive_details']['receive']['shipper']['name'],
                'receiveDate' => Carbon::parse($pb['receive_details']['receive']['created_at'])->format('M d Y g:i A')
            ]);
        }
        return $resumePreBill;
    }
}
