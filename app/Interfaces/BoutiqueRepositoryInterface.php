<?php

namespace App\Interfaces;

interface BoutiqueRepositoryInterface{
    public function queryAllForCostumer($idCostumer);
    public function query($id);
    public function queryBoutiqueAndContact($idBoutique);
    public function create($newBoutique);
    public function update($updateBoutique,$idBoutique);
    public function boutiquesInstructions($idCustomer);
}