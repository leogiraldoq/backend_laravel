<?php

namespace App\Interfaces;

interface CustomerNoProcessRepositoryInterface {
    public function create($notProcess);
    public function listPerCustomer($id);
    public function delete($id);
    public function verifyIfProcees($idCustomer,$idShipper);
}
