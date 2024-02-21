<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Repositories;

use App\Interfaces\QualityRepositoryInterface;
use App\Models\Quality;
use App\Models\ReceiveDetails;

/**
 * Description of QualityRepository
 *
 * @author LeoGiraldoQ
 */
class QualityRepository implements QualityRepositoryInterface{
    
    public function create($qualityData,$userId){
        foreach ($qualityData['qualityControl'] as $quality){
            Quality::create([
                "process_id" => $quality['idProcess'],
                "aprove" => $quality['quality'],
                "user_id" => $userId,
                "receive_details_id" => $qualityData['idRceiveDetail']
            ]);
        }
        return $this->queryReceiveDetailsQuality($qualityData['idRceiveDetail']);
    }
    
    
    public function queryReceiveDetailsQuality($idReceiveDetails){
        return ReceiveDetails::with(['quality','boutiques','receive','receive.customer'])->where("id_receive_detail",$idReceiveDetails)->get();
    }
}
