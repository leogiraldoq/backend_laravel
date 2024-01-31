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
                "stylesProcess.*.color" => "required_if:shareWork,==,true|nullable|string",
                "stylesProcess.*.quantity" => "required|integer",
            ]);
            $totalQuantity = $this->preBillRepository->totalPiecesInvoice($processValidate["preBillId"]);
            $totalProcess = 0;
            foreach($processValidate['stylesProcess'] as $style){
                $totalProcess += $style['quantity'];
            }
            if($totalQuantity < $totalProcess){
                return $this->responseError("The total pieces that you process its <b>MAYOR</b> that the pieces in the invoice, you enter <b>".$totalProcess."</b> pieces and the invoice said <b>".$totalQuantity."</b> pieces in total. Check the information or contact the manager.", 422);
            }elseif($totalQuantity > $totalProcess){
                return $this->responseError("The total pieces that you process its <b>MENOR</b> that the pieces in the invoice, you enter <b>".$totalProcess."</b> pieces and the invoice said <b>".$totalQuantity."</b> pieces in total. Check the information or contact the manager.", 422);
            }else{
                $userId = (auth()->user())->id_user;
                $processCreate = $this->processingRepository->create($processValidate, $userId);
                return $this->responseOk("Data saved", $processCreate);
            }
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
