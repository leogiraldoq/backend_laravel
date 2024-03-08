<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\ProcessingRepositoryInterface;
use App\Interfaces\EmployeesRepositoryInterface;
use Carbon\Carbon;


class ProcessingController extends Controller
{
    use ResponseTrait;
    
    private ProcessingRepositoryInterface $processingRepository;
    private EmployeesRepositoryInterface $employeeRepository;
    
    public function __construct(
            ProcessingRepositoryInterface $processingRepository,
            EmployeesRepositoryInterface $employeeRepository,
        ) {
        $this->processingRepository = $processingRepository;
        $this->employeeRepository = $employeeRepository;
    }
    
    /**
     * Create Processing repository
     * @param Object $request Data for save in the processing table
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(Request $request) {
        try {
            $processValidate = $request->validate([
                "preBillId" => "required|integer",
                "shareWork" => "required|boolean",
                "stylesProcess" => "required|array|min:1",
                "stylesProcess.*.id" => "required|string",
                "stylesProcess.*.color" => "required_if:shareWork,==,true|nullable|array",
                "stylesProcess.*.quantity" => "required|integer",
                "stylesProcess.*.set" => "required|integer",
                "workAdd" => "nullable|array"
            ]);
            $processCreate = $this->processingRepository->create($processValidate, (auth()->user())->id_user);
            if($processCreate['error']){
                return $this->responseError($processCreate['message'], $processCreate['code']);
            }
            return $this->responseOk("The revision and data was saved you start ". Carbon::parse($processCreate['data'][0]['created_at'])->format('F d Y g:i:s a'), $processCreate['data']);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    public function listPerUser(){
        try {
            $resumeProcessingUser = $this->processingRepository->resumeProcessingUser((auth()->user())->id_user);
            $employee = $this->employeeRepository->query(auth()->user()->employee_id);
            $resumeProcessingUser['whoami'] = $employee['names']." ".$employee['last_names'];
            return $this->responseOk("Resume processing per user listed", $resumeProcessingUser);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    public function listPerUserDate(Request $request){
        try {
            $validateData = $request->validate([
                "from" => "required|date",
                "to" => "required|date",
            ]);
            $resumeProcessingUser = $this->processingRepository->resumeProcessingUserDate((auth()->user())->id_user,$validateData['from'],$validateData['to']);
            $employee = $this->employeeRepository->query(auth()->user()->employee_id);
            $resumeProcessingUser['whoami'] = $employee['names']." ".$employee['last_names'];
            return $this->responseOk("Resume processing per user listed", $resumeProcessingUser);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
}
