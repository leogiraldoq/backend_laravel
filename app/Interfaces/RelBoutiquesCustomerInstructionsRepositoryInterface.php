<?php

namespace App\Interfaces;

interface RelBoutiquesCustomerInstructionsRepositoryInterface {
    public function create($idCustomerInstructions,$idsBoutiques);
    public function bringInstructiosPerBoutique($idBoutique);
}
