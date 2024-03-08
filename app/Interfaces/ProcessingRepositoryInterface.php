<?php
namespace App\Interfaces;

interface ProcessingRepositoryInterface {
    public function create($processData,$userId);
    public function showPreBillingId($preBillId);
    public function showUserId($userId);
    public function resumeProcessing($preBillId);
    public function resumeProcessingUser($userId);
    public function resumeProcessingUserDate($userId,$from,$to);
}
