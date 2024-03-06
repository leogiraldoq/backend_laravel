<?php

namespace App\Repositories;
use App\Interfaces\QrCodesRepositoryInterface;
use App\Interfaces\ReceiveDetailsRepositoryInterface;
use App\Interfaces\RelBoutiquesCustomerInstructionsRepositoryInterface;
use App\Interfaces\ProcessingRepositoryInterface;
use App\Interfaces\RelPackStoreRepositoryInterface;
use Carbon\Carbon;

/**
 * Description of QrCodeRepository
 *
 * @author LeoGiraldoQ
 */
class QrCodeRepository implements QrCodesRepositoryInterface{
    
    private ReceiveDetailsRepositoryInterface $receiveDetailsRepository;
    private RelBoutiquesCustomerInstructionsRepositoryInterface $relCostumerBoutiqueInstructionRepository;
    private ProcessingRepositoryInterface $processRepository;
    private RelPackStoreRepositoryInterface $relPackStoreRepository;
    
    public function __construct(
            ReceiveDetailsRepositoryInterface $receiveDetailsRepository,
            RelBoutiquesCustomerInstructionsRepositoryInterface $relCostumerBoutiqueInstructionRepository,
            ProcessingRepositoryInterface $processRepository,
            RelPackStoreRepositoryInterface $relPackStoreRepository
        ) {
        $this->receiveDetailsRepository = $receiveDetailsRepository;
        $this->relCostumerBoutiqueInstructionRepository = $relCostumerBoutiqueInstructionRepository;
        $this->processRepository = $processRepository;
        $this->relPackStoreRepository = $relPackStoreRepository;
    }
    
    /**
     * Return data for the qr read in the pre-bill process
     * @param String $code Base 64 id receive_details
     * @return Array Array for the field that we need to show
     * @author LeoGiraldoQ
     */
    public function showQrPreBill($code){
        $receiveDetails = $this->receiveDetailsRepository->show(json_decode(base64_decode($code))->{'idReceiveDetail'});
        $names = $receiveDetails[0]['receive']['user']['employee']['names'].' '.$receiveDetails[0]['receive']['user']['employee']['last_names'];
        $result = array(
            "received_date" => Carbon::parse($receiveDetails[0]['receive']['created_at'])->format('M d Y g:i A'),
            "follow_number" => $receiveDetails[0]['receive']['follow_number'],
            "customer" => $receiveDetails[0]['receive']['customer']['name'],
            "boutique" => $receiveDetails[0]['boutiques']['name'],
            "store" => $receiveDetails[0]['receive']['shipper']['name'],
            "process" => $receiveDetails[0]['receive']['its_process'],
            "box_type" => $receiveDetails[0]['boxes']['products']['name'],
            "box_dimensions" => $receiveDetails[0]['boxes']['dimensions'],
            "box_quantity" => $receiveDetails[0]['quantity_box'],
            "box_weight" => $receiveDetails[0]['weight_box'],
            "receibed_by" => $names,
            "special_observations" => $receiveDetails[0]['receive']['observations'],
            "id_receive_details" => $receiveDetails[0]['id_receive_detail'],
            "id_receibed_user_id" => $receiveDetails[0]['receive']['user_id'],
            "instructions" => (sizeof($receiveDetails[0]['boutiques']['rel_boutique_customer_instructions']) > 0 ? sizeof($receiveDetails[0]['boutiques']['rel_boutique_customer_instructions']) : null),
        );
        return $result;
        
    }
    
    /**
     * Return data for the qr read in the processing process
     * @param String $code Base 64 id receive_details
     * @return Array Array for the field that we need to show
     * @author LeoGiraldoQ
     */
    public function showQrProcessing($code){
        $receiveDetails = $this->receiveDetailsRepository->show(json_decode(base64_decode($code))->{'idReceiveDetail'});
        $instructions = $this->relCostumerBoutiqueInstructionRepository->bringInstructiosPerBoutique($receiveDetails[0]['boutiques']['id_boutique']);
        if($receiveDetails[0]['pre_billing'] !== null){
            $processing = $this->processRepository->resumeProcessing($receiveDetails[0]['pre_billing']['id_pre_bill']);
        }else{
            $processing = null;
        }
        $result = array(
            "customer" => $receiveDetails[0]['receive']['customer']['name'],
            "boutique" => $receiveDetails[0]['boutiques']['name'],
            "store" => $receiveDetails[0]['receive']['shipper']['name'],
            "invoiceNum" => ($receiveDetails[0]['pre_billing'] !== null ? $receiveDetails[0]['pre_billing']['invoice_number'] : null),
            "total" => ($receiveDetails[0]['pre_billing'] !== null ? $receiveDetails[0]['pre_billing']['total_pieces'] : null),
            "instructions" => (sizeof($instructions) > 0 ? json_decode($instructions[0]["rel_customer_intructions"]['instructions']) : null),
            "preBillId" => ($receiveDetails[0]['pre_billing'] !== null ? $receiveDetails[0]['pre_billing']['id_pre_bill'] : null),
            "preBillQnty" => ($receiveDetails[0]['pre_billing'] !== null ? $receiveDetails[0]['pre_billing']['quantity_styles'] : null),
            "processing" => $processing
        );
        return $result;
    }
    
    /**
     * Return data for the qr read in the quality process
     * @param String $code Base 64 id receive_details
     * @return Array Array for the field that we need to show
     * @author LeoGiraldoQ
     */
    public function showQrQuality($code){
        $receiveDetails = $this->receiveDetailsRepository->show(json_decode(base64_decode($code))->{'idReceiveDetail'});
        $instructions = $this->relCostumerBoutiqueInstructionRepository->bringInstructiosPerBoutique($receiveDetails[0]['boutiques']['id_boutique']);
        $processing = $this->processRepository->resumeProcessing($receiveDetails[0]['pre_billing']['id_pre_bill']);
        $result = array(
            "received_date" => Carbon::parse($receiveDetails[0]['receive']['created_at'])->format('M d Y g:i A'),
            "follow_number" => $receiveDetails[0]['receive']['follow_number'],
            "customer" => $receiveDetails[0]['receive']['customer']['name'],
            "boutique" => $receiveDetails[0]['boutiques']['name'],
            "store" => $receiveDetails[0]['receive']['shipper']['name'],
            "box_type" => $receiveDetails[0]['boxes']['products']['name'],
            "box_dimensions" => $receiveDetails[0]['boxes']['dimensions'],
            "box_quantity" => $receiveDetails[0]['quantity_box'],
            "box_weight" => $receiveDetails[0]['weight_box'],
            "receibed_by" => $receiveDetails[0]['receive']['user']['employee']['names'].' '.$receiveDetails[0]['receive']['user']['employee']['last_names'],
            "id_receive_details" => $receiveDetails[0]['id_receive_detail'],
            "instructions" => json_decode($instructions[0]["rel_customer_intructions"]['instructions']),
            "invoiceNum" => $receiveDetails[0]['pre_billing']['invoice_number'],
            "invoiceTotal" => $receiveDetails[0]['pre_billing']['total_pieces'],
            "preBillId" => $receiveDetails[0]['pre_billing']['id_pre_bill'],
            "processing" => $processing,
            "quality" => $receiveDetails[0]['quality'],
        );
        return $result;
    }
    
    public function showQrShipping($code){
        $receiveDetails = $this->receiveDetailsRepository->show(json_decode(base64_decode($code))->{'idReceiveDetail'});
        $relPackStore = $this->relPackStoreRepository->showReceiveDetailsId(json_decode(base64_decode($code))->{'idReceiveDetail'});
        $instructions = json_decode($this->relCostumerBoutiqueInstructionRepository->bringInstructiosPerBoutique($receiveDetails[0]['boutiques']['id_boutique'])[0]["rel_customer_intructions"]['instructions']);
        unset($instructions->{'sampleImage'});
        $receiveDetails[0]['receive']['shipper']['id_receive_details'] = $receiveDetails[0]['id_receive_detail'];
        $result = array(
            "follow_number" => $receiveDetails[0]['receive']['follow_number'],
            "customer" => $receiveDetails[0]['receive']['customer']['name'],
            "customerId" => $receiveDetails[0]['receive']['customer']['id_costumer'],
            "customerPickUpCompany" => $receiveDetails[0]['receive']['customer']['pick_up_company']['name'],
            "boutique" => $receiveDetails[0]['boutiques']['name'],
            "boutiqueId" => $receiveDetails[0]['boutiques']['id_boutique'],
            "store" => $receiveDetails[0]['receive']['shipper'],
            "box_type" => $receiveDetails[0]['boxes']['products']['name'],
            "box_dimensions" => $receiveDetails[0]['boxes']['dimensions'],
            "box_quantity" => $receiveDetails[0]['quantity_box'],
            "box_weight" => $receiveDetails[0]['weight_box'],
            "id_receive_details" => $receiveDetails[0]['id_receive_detail'],
            "instructions" => $instructions,
            "qualityDate" => Carbon::parse($receiveDetails[0]['quality'][0]['created_at'])->format('M d Y g:i A'),
            "qualityUser" => $receiveDetails[0]['quality'][0]['user']['employee']['names']." ".$receiveDetails[0]['quality'][0]['user']['employee']['last_names'],
            "process" => $receiveDetails[0]['receive']['its_process'],
            "product" => $receiveDetails[0]['boxes']['products'],
            "box" => $receiveDetails[0]['boxes'],
            "action" => null,
            "prepare" => $relPackStore
        );
        return $result;
    }
}
