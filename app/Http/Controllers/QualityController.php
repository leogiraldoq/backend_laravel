<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\QualityRepositoryInterface;

class QualityController extends Controller
{
    use ResponseTrait;
    
    private QualityRepositoryInterface $qualityRepository;
    
    public function __construct(QualityRepositoryInterface $qualityRepository) {
        $this->qualityRepository = $qualityRepository;
    }
    
    public function create(Request $quality){
        try {
            $qualityValidate = $quality->validate([
               "idRceiveDetail" => "required|integer",
               "qualityControl" => "required|array|min:1",
               "qualityControl.*.idProcess" => "required|integer",
               "qualityControl.*.quality" => "required|in:1",
            ]);
            $qualityCreate = $this->qualityRepository->create($qualityValidate, (auth()->user())->id_user);
            return $this->responseOk("The order # ".$qualityCreate[0]['receive']['follow_number']." for the customer ".$qualityCreate[0]['receive']['customer']['name']." boutique ".$qualityCreate[0]['boutiques']['name']." its ready to packing", $qualityCreate);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
}
