<?php

namespace App\Interfaces;

interface TrackingRepositoryInterface {
    public function generalResume();
    public function preBillProcessCustomerResume();
    public function preBillProcessBoutiqueDetails($idBoutique);
    public function showBillEmployee();
}
