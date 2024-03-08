<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Repositories;
use App\Interfaces\DeliveryRepositoryInterface;
use App\Interfaces\BoutiqueContactRepositoryInterface;
use App\Models\Delivery;
use App\Models\RelPackDelivery;
use \Carbon\Carbon;
use App\Models\Boutiques;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryTicket;
/**
 * Description of DeliveryRepository
 *
 * @author LeoGiraldoQ
 */
class DeliveryRepository implements DeliveryRepositoryInterface{
    
    private BoutiqueContactRepositoryInterface $boutiqueRepository;
    
    public function __construct(BoutiqueContactRepositoryInterface $boutiqueRepository){
        $this->boutiqueRepository = $boutiqueRepository;
    }
    
    public function save($deliveryData,$userId){
        $deliver = Delivery::create([
            "names" => $deliveryData['namePickUp'],
            "pickup_id" => $deliveryData['pickUpId'],
            "user_id" => $userId,
            "photo" => $deliveryData['photoPickUp'],
            "signature" => $deliveryData['signPickUp'],
            "follow_number" => $deliveryData['ticketNum'],
            "created_at" => Carbon::parse($deliveryData['ticketDate'])->format('M d Y H:m:s'),
            "email" => $deliveryData['email']
        ]);
        $deliver['rel_pack_delivery'] = $this->createRelPackDeliver($deliver['id_delivery'], $deliveryData['packIds']);
        $pdfTicket = $this->createTicketDelivery($deliver['id_delivery']);
        $updateTicket = $this->updateTicketFile($deliver['id_delivery'], $pdfTicket['file']);
        $this->sendMailBoutique($pdfTicket['data'],$pdfTicket['file']);
        return $pdfTicket;
    }
    
    public function updateTicketFile($idDelivery,$ticketB64){
        return Delivery::where('id_delivery',$idDelivery)->update([
            "ticket" => $ticketB64
        ]);
    }
    
    public function createRelPackDeliver($deliverId,$packIds){
        $dataReturn = array();
        foreach ($packIds as $id_pack){
            $relPackDeliver = RelPackDelivery::create([
                'packing_id' => $id_pack,
                'delivery_id' => $deliverId
            ]);
            array_push($dataReturn,$relPackDeliver);
        }
        return $dataReturn;
    }
    
    
    private function dataTicket($idDelivery){
        return Delivery::with([
            'user.employee',
            'pick_up_company',
            'rel_pack_delivery.packing',
            'rel_pack_delivery.packing.boxes.products',
            'rel_pack_delivery.packing.relPackStore.shipper',
            'rel_pack_delivery.packing.boutiques.costumer',
            'rel_pack_delivery.packing.boutiques.boutique_contacts'
        ])->where('id_delivery',$idDelivery)->get()->toArray();
    }
    
    private function createTicketDelivery($idDelivery){
        $dataDeliver = $this->dataTicket($idDelivery);
        $pdfData = array();
        $mailData = array();
        foreach($dataDeliver as $delivery){
            $pdfData['ticketNumber'] = $delivery['follow_number'];
            $pdfData['dateDelivery'] = $delivery['created_at'];
            $pdfData['pickUpCompany'] = $delivery['pick_up_company']['name'];
            $pdfData['pickUpNames'] = $delivery['names'];
            $pdfData['pickUpSign'] = $delivery['signature'];
            $pdfData['whodelivery'] = $delivery['user']['employee']['names'].' '.$delivery['user']['employee']['last_names'];
            $pdfData['dateDelivery'] = Carbon::parse($delivery['created_at'])->format('M d Y g:i A');
            $pdfData['resume'] = array();
            $pdfData['boutiqueContact'] = array();
            foreach($delivery['rel_pack_delivery'] as $pack){
                $stores = array();
                foreach($pack['packing']['rel_pack_store'] as $store){
                    array_push($stores,$store['shipper']['name']);
                }
                foreach($pack['packing']['boutiques']['boutique_contacts'] as $contact){
                    array_push($pdfData['boutiqueContact'],[
                        "name" => $contact['contact_name'],
                        "email" => $contact['email'],
                        "phone" => $contact['phone']
                    ]);
                }
                array_push($pdfData['resume'],[
                    "quantity" => $pack['packing']['quantity'],
                    "weight" => $pack['packing']['weight'],
                    "size" => $pack['packing']['boxes']['dimensions'],
                    "product" => $pack['packing']['boxes']['products']['name'],
                    "stores" => implode(', ',$stores),
                    "boutique" => $pack['packing']['boutiques']['name'],
                ]);
                $pdfData['customer'] = $pack['packing']['boutiques']['costumer']['name'];
            }
            $pdfData['boutiqueContact'] = array_map('unserialize', array_unique(array_map('serialize', $pdfData['boutiqueContact'])));
            $ticketDimensions = array(0,0,216,900);
            $pdf = Pdf::loadView('pdf.ticket-send', compact('pdfData'))->setPaper($ticketDimensions, "portrait");
            return [
                "file" => base64_encode($pdf->output()),
                "data" => $pdfData
            ];   
        }
    }
    
    private function sendMailBoutique($dataMail,$attachFile){
        foreach ($dataMail['boutiqueContact'] as $mail){
            Mail::to($mail['email'])->queue( new DeliveryTicket($dataMail,$attachFile,$mail['name']));
        }
    }

}
