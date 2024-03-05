<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace App\Interfaces;

/**
 *
 * @author LeoGiraldoQ
 */
interface ReceiveSupportsRepositoryInterface {
    public function selectOne($idReceive);
    public function upsertTicket($receiveId, $ticket);
    public function upsertSticker($receiveId, $sticker);
    public function insert($receiveId, $sticker, $ticket);
    public function selectByReceiveId($idReceive);
}
