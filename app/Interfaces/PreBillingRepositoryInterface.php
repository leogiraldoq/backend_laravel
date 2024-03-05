<?php

namespace App\Interfaces;

/**
 *
 * @author LeoGiraldoQ
 */
interface PreBillingRepositoryInterface {
    public function create($preBillData,$userId);
    public function show($idReceiveDeteails);
    public function totalPiecesInvoice($idPreBill);
    public function listAll();
}
