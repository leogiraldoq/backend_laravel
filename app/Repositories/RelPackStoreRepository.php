<?php

namespace App\Repositories;
use App\Interfaces\RelPackStoreRepositoryInterface;
use App\Models\RelPackingStore;

/**
 * Description of RelPackStoreRepository
 *
 * @author LeoGiraldoQ
 */
class RelPackStoreRepository implements RelPackStoreRepositoryInterface{
    
    public function create($packId,$stores){
        $returnR = array();
        foreach($stores as $store){
            $relResult = RelPackingStore::create([
                "pack_id" => $packId,
                "receive_details_id" => $store['id_receive_details'],
                "shipper_id" => $store['id_shipper'],
            ])->toArray();
            $relResult['nameStore'] = $store['name'];
            array_push($returnR,$relResult);
        }
        return $returnR;
    }
    
    public function showReceiveDetailsId($idReceiveDatils){
        return RelPackingStore::where('receive_details_id',$idReceiveDatils)->with(['packing','shipper'])->get()->toArray();
    }
    
}
