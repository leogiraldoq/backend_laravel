<?php

namespace App\Http\Controllers;

use App\Interfaces\RelCostumerIntructionsRepositoryInterface;
use App\Http\Requests\CreateUpdateInstructionsCostumerRequest;
use App\Interfaces\BoutiqueRepositoryInterface;
use \App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class InstructionsController extends Controller
{
    //Traits
    use ResponseTrait;
    
    //Repositories
    private RelCostumerIntructionsRepositoryInterface $relCostumerInstructionsRepository;
    private BoutiqueRepositoryInterface $boutiqueRepository;
    
    public function __construct(
            RelCostumerIntructionsRepositoryInterface $relCostumerInstructionsRepository,
            BoutiqueRepositoryInterface $boutiqueRepository
    ) {
        $this->relCostumerInstructionsRepository = $relCostumerInstructionsRepository;
        $this->boutiqueRepository = $boutiqueRepository;
    }
    
    /**
     * Create a list of instructions per costumer
     * @param Request $request Request for create instructions per costumer
     * @return \Illuminate\Http\JsonResponse return a object
     * @author LeoGiraldoQ
     */
    public function create(CreateUpdateInstructionsCostumerRequest $request){
        try{
            $instructionsCostumer = $request->validated();
            $instructions = $this->relCostumerInstructionsRepository->create($instructionsCostumer);
            $boutiquesInstructions = $this->boutiqueRepository->boutiquesInstructions($instructionsCostumer);
            return $this->responseOk("Instructions created",$boutiquesInstructions);
        } catch (\Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
}
