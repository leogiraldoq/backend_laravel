<?php

namespace App\Repositories;

use App\Models\RelCostumerInstruction;
use App\Interfaces\RelCostumerIntructionsRepositoryInterface;
use App\Interfaces\RelBoutiquesCustomerInstructionsRepositoryInterface;

class RelCostumerInstructionsRepository implements RelCostumerIntructionsRepositoryInterface
{
    private RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiqueInstructionRepository;
    
    public function __construct(
            RelBoutiquesCustomerInstructionsRepositoryInterface $relBoutiqueInstructionRepository
    ){
        $this->relBoutiqueInstructionRepository = $relBoutiqueInstructionRepository;
    }

    
    /**
     * Create instruction for customer
     * @param Object $instructionsClient Object whit the instructions and tthe idCustomer and boutiques
     * @return  Model
     * @author LeoGiraldoQ
     */
    public function create($instructionsClient){
        $customerIns = RelCostumerInstruction::create([
            'costumer_id' => $instructionsClient['customerId'],
            'title' => $instructionsClient['title'],
            'instructions' => json_encode($instructionsClient)
        ]);
        $relBoutiqueIns = $this->relBoutiqueInstructionRepository->create($customerIns['id'], $instructionsClient['boutiques']);
        return $customerIns;
    }

}
