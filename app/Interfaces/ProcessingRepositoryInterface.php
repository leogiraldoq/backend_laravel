<?php
namespace App\Interfaces;

interface ProcessingRepositoryInterface {
    public function create($processData,$userId);
    public function showPreBillingId($preBillId);
}
