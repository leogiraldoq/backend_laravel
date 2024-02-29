<?php

namespace App\Interfaces;

interface QrCodesRepositoryInterface {
    public function showQrPreBill($code);
    public function showQrProcessing($code);
    public function showQrQuality($code);
    public function showQrShipping($code);
}
