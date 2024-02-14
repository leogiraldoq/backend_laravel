<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\ReceiveRepositoryInterface;
use App\Interfaces\ReceiveDetailsRepositoryInterface;
use App\Interfaces\ReceiveSupportsRepositoryInterface;
use App\Interfaces\RelBoutiquesCustomerInstructionsRepositoryInterface;
use App\Http\Requests\CreateRecibingRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReceiveController extends Controller
{
    use ResponseTrait;

    private ReceiveRepositoryInterface $receiveRepository;
    private ReceiveDetailsRepositoryInterface $receiveDetailRepository;
    private ReceiveSupportsRepositoryInterface $receiveSupportRepository;
    private RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiqueInstructions;
    
    
    public function __construct(
            ReceiveRepositoryInterface $receiveRepository,
            ReceiveDetailsRepositoryInterface $receiveDetailRepository,
            ReceiveSupportsRepositoryInterface $receiveSupportRepository,
            RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiqueInstructions
        ) 
    {
        $this->receiveRepository = $receiveRepository;
        $this->receiveDetailRepository = $receiveDetailRepository;
        $this->receiveSupportRepository = $receiveSupportRepository;
        $this->relBoutiqueInstructions = $relBoutiqueInstructions;
    }
    
    
    /**
     * Create receive boxes
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(CreateRecibingRequest $request){
        try {
            $validateRecibe = $request->validated();
            if(is_null($validateRecibe['user'])){
                $validateRecibe['user'] = (auth()->user())->id_user;
            }
            $recibe = $this->receiveRepository->create($validateRecibe);
            $stickers = $this->createStikers($recibe['ticket']);
            $recibe['ticket']['stickers'] = ($this->receiveSupportRepository->upsertSticker($recibe['ticket']['id_receive'], $stickers))['stickers'];
            return $this->responseOk("Receive #".$recibe['ticket']['follow_number']." was create", $recibe);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
    
    /**
     * List receive boxes in specific date
     * @param Date $date Date for the condition query
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function queryByDate($date){
        try {
            $receivePerDate = $this->receiveRepository->queryByDate($date);
            return $this->responseOk("Receive listed for ".$date, $receivePerDate);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    /**
     * List receive details boxes in specific date
     * @param Date $date Date for the condition query
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function queryDetailsPerDate($date){
        try {
            $receiveDetails = $this->receiveDetailRepository->queryByDate($date);
            return $this->responseOk("Receive details listed", $receiveDetails);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    /**
     * List all receive boxes
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function queryAll(){
        try {
            $receive = $this->receiveRepository->showAll();
            return $this->responseOk("Receive listed", $receive);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    /**
     * List all receive details boxes
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function queryAllDetails(){
        try {
            $receive = $this->receiveDetailRepository->showAll();
            return $this->responseOk("Receive listed", $receive);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    
    /**
     * Create a qr code with the information for the receive and add to the object
     * @param Object $receiveData Data fro the create receive
     * @return Object add the element qrCode
     * @author LeoGiraldoQ
     */
    private function createStikers($receiveData){
            $stickerData = array();
            $sendToView=array();
            foreach ($receiveData['receive_details'] as $details ){
                $boutiqueInstructions = $this->relBoutiqueInstructions->bringInstructiosPerBoutique($details['boutiques']['id_boutique']);
                if($boutiqueInstructions){
                    $process = json_decode($boutiqueInstructions[0]['rel_customer_intructions']['instructions'])->{'packing'};
                }else{
                    $process = "Instructions no created";
                }
                $qrBase64 = base64_encode(\QrCode::format('png')->size(200)->errorCorrection('H')->generate(base64_encode($details['id_receive_detail'])));
                for($q=0 ; $q < $details['quantity_box'] ; $q++){
                    $stickerData['boutique'] = strtoupper($details['boutiques']['name']);
                    $stickerData['customer'] = strtoupper($receiveData['customer']['name']);
                    $stickerData['received'] = strtoupper(Carbon::parse($receiveData['created_at'])->format('F d Y H:i:s'));
                    $stickerData['store'] = strtoupper($receiveData['shipper']['name']);
                    $stickerData['process'] = $receiveData['its_process'];
                    $stickerData['shipping'] = strtoupper("TO: ".$process);
                    $stickerData['stickerNumber'] = "BOX: ".($q+1)." of ".$details['quantity_box'];
                    $stickerData['qr'] = $qrBase64;
                    $stickerData['box'] = strtoupper($details['boxes']['describe']);
                    array_push($sendToView,$stickerData);
                }
            }
            $stickerDimensions = array(0,0,432,288);
            $pdf = Pdf::loadView('pdf.stiker-receive', compact('sendToView'))->setPaper($stickerDimensions, "landscape");
            return base64_encode($pdf->output());
    }
    
    
    /**
     * Create a PDF with the qr and the other information
     * @param Object $pdfContent Data with information to make the qr and additional information
     * @return PDF file
     * @author LeoGiraldoQ
     */
    public function stickersPDF($pdfContent){
        try{
            
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    /**
     * Create ticket
     * @param Request $receiveTicket
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     */
    public function addTicketSupport(Request $receiveTicket){
        try {
            $valReceibeSupport = $receiveTicket->validate([
                'receiveId' => 'required|integer',
                'ticket' => 'required|string'
            ]);
            $ticketSave = $this->receiveSupportRepository->upsertTicket($valReceibeSupport['receiveId'], $valReceibeSupport['ticket']);
            return $this->responseOk("Ticket created", $ticketSave);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
