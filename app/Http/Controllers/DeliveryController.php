<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\DeliveryRepositoryInterface;


class DeliveryController extends Controller
{
    use ResponseTrait;
    
    private DeliveryRepositoryInterface $deliveryRepository;
    
    public function __construct(DeliveryRepositoryInterface $deliveryRepository) {
        $this->deliveryRepository = $deliveryRepository;
    }
    
    public function save(Request $request){
        try {
            $validateData = $request->validate([
                "namePickUp" => "required|string|min:3",
                "signPickUp" => "required",
                "photoPickUp" => "required",
                "ticketNum" => "required",
                "ticketDate" => "required",
                "pickUpId" => "required|integer",
                "packIds" => "required|array|min:1",
                "email" => "nullable|email"
            ]);
            $pdfTicket = $this->deliveryRepository->save($validateData, (auth()->user())->id_user);
            dd($pdfTicket);
            return $this->responseOk("Delivery # ".$pdfTicket['data']['ticketNumber']." saved",$pdfTicket['file']);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
