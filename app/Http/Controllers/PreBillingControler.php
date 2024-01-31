<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\PreBillingRepositoryInterface;

class PreBillingControler extends Controller
{
    use ResponseTrait;
    
    private PreBillingRepositoryInterface $preBillRepository;
    
    public function __construct(PreBillingRepositoryInterface $preBillRepository) {
        $this->preBillRepository = $preBillRepository;
    }
    
    /**
     * Create a prebilling record
     * @param Object $request Pre billing data
     * @return ResponseTrait
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(Request $request){
        try {
            $preBillValidate = $request->validate([
               "receiveDetailId" => "required|integer",
                "invoiceNumber" => "required|integer",
                "invoicesTotal" => "required|integer",
                "invoicesQuantityStyles" => "nullable|integer",
                "invoicesDocument" => "nullable|string",
            ]);
            $userId = (auth()->user())->id_user;
            $preBill = $this->preBillRepository->create($preBillValidate,$userId);
            return $this->responseOk("Pre billing invoice number: ".$preBill["invoice_number"]." create.", $preBill);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
        }
    
}
