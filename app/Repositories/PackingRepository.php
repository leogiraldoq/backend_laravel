<?php

namespace App\Repositories;
use App\Interfaces\PackingRepositoryInterface;
use App\Interfaces\RelPackStoreRepositoryInterface;
use App\Models\Packing;
use App\Models\Costumers;

/**
 * Description of PackingRepository
 *
 * @author LeoGiraldoQ
 */
class PackingRepository implements PackingRepositoryInterface{
    
    private RelPackStoreRepositoryInterface $relPackStoreRepository;
    
    public function __construct(RelPackStoreRepositoryInterface $relPackStoreRepository) {
        $this->relPackStoreRepository = $relPackStoreRepository;
    }
    
    
    public function createPrepareSend($prepareData,$userId){
        $returnR = array();
        foreach ($prepareData['prepare'] as $prepare){
            $packing = Packing::create([
                "user_id" => $userId,
                "customer_id" => $prepareData['customer'],
                "boutique_id" => $prepareData['boutique'],
                "box_id" => $prepare['type']['id_box'],
                "weight" => $prepare['weight'],
                "quantity" => $prepare['quantity']
            ])->toArray();
            $rel = $this->relPackStoreRepository->create($packing['id_pack'], $prepare['stores']);
            $packing['rel_pack_store'] = $rel;
            array_push($returnR,$packing);
        }
        return $returnR;
    }
    
    
    public function customerToDelivery(){
        $dataReturn = array();
        $toDelivery = Costumers::with(['pick_up_company','packing','packing.rel_pack_delivery','packing.boutiques'])->get()->toArray();
        foreach($toDelivery as $customers){
            if(sizeof($customers['packing']) > 0){
                $prepareData = Array();
                $prepareData['boxQuantity'] = 0;
                $prepareData['boutiqueQuantity'] = 0;
                foreach($customers['packing'] as $deliver){
                    $prepareData['customerId'] = $customers['id_costumer'];
                    $prepareData['customers'] = $customers['name'];
                    $prepareData['pickUpCompany'] = $customers['pick_up_company']['name'];
                    $prepareData['boxQuantity'] = $prepareData['boxQuantity'] + $deliver['quantity'];
                    $prepareData['boutiqueQuantity'] = $prepareData['boutiqueQuantity']+1;
                }
                array_push($dataReturn,$prepareData);
            }
        }
        return $dataReturn;
    }
    
    public function toDeliveryPerCustomer($idCustomer){
        $dataReturn = array();
        $customerDelivery = Costumers::with([
            'pick_up_company',
            'packing',
            'packing.boxes',
            'packing.boxes.products',
            'packing.relPackStore',
            'packing.relPackStore.shipper',
            'packing.rel_pack_delivery',
            'packing.boutiques'
        ])->where('id_costumer',$idCustomer)->get()->toArray();
        foreach($customerDelivery as $customers){
            $dataReturn['idCustomer'] = $customers['id_costumer']; 
            $dataReturn['customer'] = $customers['name']; 
            $dataReturn['idPickUp'] = $customers['pick_up_company']['id_pick_up_company']; 
            $dataReturn['pickUp'] = $customers['pick_up_company']['name'];
            $dataReturn['packIds'] = array();
            if(sizeof($customers['packing']) > 0){
                $dataReturn['packing'] = array();
                foreach($customers['packing'] as $deliver){
                    $stores = array();
                    foreach ($deliver['rel_pack_store'] as $store){
                        array_push($stores,$store['shipper']['name']);
                    }
                    array_push($dataReturn['packIds'],$deliver['id_pack']);
                    array_push($dataReturn['packing'],[
                        "idPack" => $deliver['id_pack'],
                        "product" => $deliver['boxes']['products']['name'],
                        "size" => $deliver['boxes']['dimensions'],
                        "quantity" => $deliver['quantity'],
                        "boutique" => $deliver['boutiques']['name'],
                        "store" => implode(', ',$stores),
                        "weight" => $deliver['weight'],
                    ]);
                }
                
            }
        }
        return $dataReturn;
    }
        
}
