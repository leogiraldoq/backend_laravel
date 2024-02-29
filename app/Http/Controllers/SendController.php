<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\BoutiqueRepositoryInterface;
use App\Interfaces\PackingRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SendController extends Controller
{
    use ResponseTrait;
    private PackingRepositoryInterface $packingRepository;
    private BoutiqueRepositoryInterface $boutiqueRepository;
    
    public function __construct(
            PackingRepositoryInterface $packingRepository,
            BoutiqueRepositoryInterface $boutiqueRepository
    ) {
        $this->packingRepository = $packingRepository;
        $this->boutiqueRepository = $boutiqueRepository;
    }
    
    
    public function createPrepare(Request $packingPrepare){
        try {
            $packValidate = $packingPrepare->validate([
                "customer" => "required|integer",
                "boutique" => "required|integer",
                "prepare" => "required|array|min:1",
                "prepare.*.quantity" => "required|integer|min:1",
                "prepare.*.product" => "required",
                "prepare.*.type" => "required",
                "prepare.*.weight" => "nullable|integer",
                "prepare.*.stores" => "required|array|min:1",
                "prepare.*.stores.*.id_receive_details" => "required|integer",
                "prepare.*.stores.*.name" => "required|string",
                "prepare.*.stores.*.id_shipper" => "required|integer"
            ]);
            $prepareData = $this->packingRepository->createPrepareSend($packValidate, (auth()->user())->id_user);
            $boutique = $this->boutiqueRepository->query($packValidate['boutique']);
            $prepareData['stickers'] = $this->createStikers($prepareData,$boutique);
            return $this->responseOk("Prepare packing saved, its ready to deliver", $prepareData); 
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    
    private function createStikers($packingData,$customerBoutique){
            $stickerData = array();
            $sendToView=array();
            foreach ($packingData as $details ){
                for($q=0 ; $q < $details['quantity'] ; $q++){
                    $stickerData['boutique'] = strtoupper($customerBoutique['name']);
                    $stickerData['customer'] = strtoupper($customerBoutique['costumer']['name']);
                    $stickerData['stickerNumber'] = "BOX: ".($q+1)." of ".$details['quantity'];
                    $stickerData['prepare'] = strtoupper(Carbon::parse($details['created_at'])->format('M d Y g:i A'));
                    $qrBox = json_encode([
                        "idPacking" => $details['id_pack'],
                        "boxNumber" => ($q+1)
                    ]);
                    $stickerData['qr'] = base64_encode(\QrCode::format('png')->size(200)->errorCorrection('H')->generate(base64_encode($qrBox)));
                    array_push($sendToView,$stickerData);
                }
            }
            $stickerDimensions = array(0,0,432,288);
            $pdf = Pdf::loadView('pdf.stiker-send', compact('sendToView'))->setPaper($stickerDimensions, "landscape");
            return base64_encode($pdf->output());
    }
    
    private function implode_key_value($separator, $array, $element=null) {
        return implode(
            $separator,
            array_map(
                function ($k, $v) use ($element){
                    if($k === $element){
                        return $v;
                    }
                    return;
                    
                },
                array_keys($array),
                array_values($array)
            )
        );
    }
    
    public function toDelivery(){
        try {
            $toDeliver = $this->packingRepository->customerToDelivery();
            return $this->responseOk("The customers ready to delivery was list", $toDeliver);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }

    public function toDeliveryPerCustumer($idCustomer){
        try {
            
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
}
