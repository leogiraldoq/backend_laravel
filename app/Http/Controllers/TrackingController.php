<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\TrackingRepositoryInterface;

class TrackingController extends Controller
{
    use ResponseTrait;
    private TrackingRepositoryInterface $trackingRepository;
    
    public function __construct(TrackingRepositoryInterface $trackingRepository) {
        $this->trackingRepository = $trackingRepository;
    }
    
    
    public function generalResume(){
        try {
            $track = $this->trackingRepository->generalResume();
            return $this->responseOk("Data listed", $track);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    public function resumePreBillProcessCustomer(){
        try {
            $billCustomer = $this->trackingRepository->preBillProcessCustomerResume();
            return $this->responseOk("Data listed", $billCustomer);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    public function detailsPreBillProcessBoutique($idBoutique){
        try {
            $details = $this->trackingRepository->preBillProcessBoutiqueDetails($idBoutique);
            return $this->responseOk("Data listed", $details);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    public function processingBillUser(){
        try {
            $details = $this->trackingRepository->showBillEmployee();
            return $this->responseOk("Data listed", $details);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
