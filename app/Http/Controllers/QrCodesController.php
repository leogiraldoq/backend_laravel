<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\ReceiveDetailsRepositoryInterface;

class QrCodesController extends Controller
{
    
    use ResponseTrait;
    
    private ReceiveDetailsRepositoryInterface $receiveDetailsRepository;
    
    
    public function __construct(ReceiveDetailsRepositoryInterface $receiveDetailsRepository) {
        $this->receiveDetailsRepository = $receiveDetailsRepository;
    }
    
    /**
     * Read qr codes for the pre billing process and return data
     * @param String $code Base 64 encode id receiving details
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function readQrPreBill($code){
        try{
            $qrInfo = $this->receiveDetailsRepository->showQrPreBill($code);
            return $this->responseOk("Qr readed pre bill", $qrInfo);
        } catch (\Exception $ex) {
            $this->responseError($ex->getMessage());
        }
    }
    
    /**
     * Read qr codes for the processing process and return data
     * @param String $code Base 64 encode id receiving details
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function readQrProcessing($code){
        try{
            $qrInfo = $this->receiveDetailsRepository->showQrProcessing($code);
            return $this->responseOk("Qr readed processing", $qrInfo);
        } catch (\Exception $ex) {
            $this->responseError($ex->getMessage());
        }
    }
}
