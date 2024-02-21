<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\ProcessingRepositoryInterface;
use App\Interfaces\PreBillingRepositoryInterface;


class ProcessingController extends Controller
{
    use ResponseTrait;
    
    private ProcessingRepositoryInterface $processingRepository;
    private PreBillingRepositoryInterface $preBillRepository;
    
    public function __construct(
            ProcessingRepositoryInterface $processingRepository,
            PreBillingRepositoryInterface $preBillRepository
        ) {
        $this->processingRepository = $processingRepository;
        $this->preBillRepository = $preBillRepository;
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
            $userId = (auth()->user())->id_user;
            $processCreate = $this->processingRepository->create($processValidate, $userId);
            if($processCreate['error']){
                return $this->responseError($processCreate['message'], $processCreate['code']);
            }
            return $this->responseOk("The revision and data was saved you start ".Carbon::parse($receiveData['created_at'])->format('F d Y g:i:s a'), $processCreate);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
