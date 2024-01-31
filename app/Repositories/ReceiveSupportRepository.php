<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Repositories;
use App\Interfaces\ReceiveSupportsRepositoryInterface;
use App\Models\ReceiveSupports;

class ReceiveSupportRepository implements ReceiveSupportsRepositoryInterface{
    
    /**
     * Bring 
     * 
     */
    public function selectOne($idReceive){
        return ReceiveSupports::where('id',$idReceive)->get();
    }
    
    public function upsertTicket($receiveId, $ticket){
        return ReceiveSupports::updateOrCreate(
           ['receive_id' => $receiveId],
           ['ticket' => $ticket]
        );
    }
    
    public function upsertSticker($receiveId, $sticker){
        return ReceiveSupports::updateOrCreate(
           ['receive_id' => $receiveId],
           ['stickers' => $sticker]
        );
    }
}