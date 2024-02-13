<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\ReceiveDetailsRepositoryInterface;
use App\Interfaces\EmployeesRepositoryInterface;

class QrCodesController extends Controller
{
    
    use ResponseTrait;
    
    private ReceiveDetailsRepositoryInterface $receiveDetailsRepository;
    private EmployeesRepositoryInterface $employeeRepository;
    
    
    public function __construct(ReceiveDetailsRepositoryInterface $receiveDetailsRepository, EmployeesRepositoryInterface $employeeRepository) {
        $this->receiveDetailsRepository = $receiveDetailsRepository;
        $this->employeeRepository = $employeeRepository;
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
            $employee = $this->employeeRepository->query(auth()->user()->employee_id);
            $qrInfo['whoami'] = $employee['names']." ".$employee['last_names'];
            return $this->responseOk("Qr readed processing", $qrInfo);
        } catch (\Exception $ex) {
            $this->responseError($ex->getMessage());
        }
    }
}
