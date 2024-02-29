<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\QrCodesRepositoryInterface;
use App\Interfaces\EmployeesRepositoryInterface;
use App\Interfaces\ProcessAddWorkRepositoryInterface;
use Carbon\Carbon;
use App\Events\PreBilling;
use App\Events\Packing;

class QrCodesController extends Controller
{
    
    use ResponseTrait;
    
    private QrCodesRepositoryInterface $qrCodeRepository;
    private EmployeesRepositoryInterface $employeeRepository;
    private ProcessAddWorkRepositoryInterface $processAddWork;
    
    
    
    public function __construct(
            QrCodesRepositoryInterface $qrCodeRepository, 
            EmployeesRepositoryInterface $employeeRepository,
            ProcessAddWorkRepositoryInterface $processAddWork
    ){
        $this->qrCodeRepository = $qrCodeRepository;
        $this->employeeRepository = $employeeRepository;
        $this->processAddWork = $processAddWork;
    }
    
    /**
     * Read qr codes for the pre billing process and return data
     * @param String $code Base 64 encode id receiving details
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function readQrPreBill($code,$channel){
        try{
            $qrInfo = $this->qrCodeRepository->showQrPreBill($code);
            if($channel !== 'null'){
                broadcast(new PreBilling($qrInfo,$channel))->toOthers();
                return $this->responseOk("Qr readed and send to the user");
            }else{
                return $this->responseOk("Qr readed pre bill", $qrInfo);
            }
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
            $qrInfo = $this->qrCodeRepository->showQrProcessing($code);
            $employee = $this->employeeRepository->query(auth()->user()->employee_id);
            $qrInfo['whoami'] = $employee['names']." ".$employee['last_names'];
            $qrInfo['addWork'] = $this->processAddWork->showAll();
            return $this->responseOk("Qr readed processing", $qrInfo);
        } catch (\Exception $ex) {
            $this->responseError($ex->getMessage());
        }
    }
    
    /**
     * Read qr codes for the quality process and return data
     * @param String $code Base 64 encode id receiving details
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function readQrQuality($code){
        try{
            $qrInfo = $this->qrCodeRepository->showQrQuality($code);
            $employee = $this->employeeRepository->query(auth()->user()->employee_id);
            $qrInfo['whoami'] = $employee['names']." ".$employee['last_names'];
            return $this->responseOk("Qr readed processing", $qrInfo);
        } catch (\Exception $ex) {
            $this->responseError($ex->getMessage());
        }
    }
    
    public function readQrShipping($code,$channel){
        try{
            $qrInfo = $this->qrCodeRepository->showQrShipping($code);
            $employee = $this->employeeRepository->query(auth()->user()->employee_id);
            if($channel !== 'null'){
                broadcast(new Packing($qrInfo,$channel))->toOthers();
                return $this->responseOk("Qr readed and send to the user");
            }else{
                return $this->responseOk("Qr readed", $qrInfo);
            }
        } catch (\Exception $ex) {
            $this->responseError($ex->getMessage());
        }
    }
}
