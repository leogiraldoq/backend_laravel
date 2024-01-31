<?php

namespace App\Repositories;

use App\Interfaces\RelBoutiquesCustomerInstructionsRepositoryInterface;
use App\Models\RelBoutiqueCustomerInstructions;

class RelBoutiquesCustomerInstructionsRepository implements RelBoutiquesCustomerInstructionsRepositoryInterface{
    
    /**
     * Create he relation for the instructions customer to boutique
     * @param Integer $idCustomerInstruction Id for the customer instruction table rel_customer_instructions
     * @param Array $idsBoutiques Boutiques that will be assign to the instruction
     * @return Model Result for the insert in the table
     * @author LeoGiraldoQ
     */
    public function create($idCustomerInstructions,$idsBoutiques){
        foreach($idsBoutiques as $idBoutique){
            $relBoutiqueCustomerInstruction[] = RelBoutiqueCustomerInstructions::create([
                "boutique_id" => $idBoutique,
                "rel_cus_ins_id" => $idCustomerInstructions
            ]);
        }
        return $relBoutiqueCustomerInstruction;
    }
    
    
    /**
     * Bring instructions per boutique
     * @param Integer $idBoutique Boutique Id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function bringInstructiosPerBoutique($idBoutique){
        return RelBoutiqueCustomerInstructions::where([
            ['boutique_id','=',$idBoutique],
            ['principal','=',true]
        ])->with(['relCustomerIntructions'])->get()->toArray();
    }
    
}
