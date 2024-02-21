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
               "qualityControl.*.quality" => "required|boolean",
               "qualityControl.*.quality" => Rule::in([true])
            ]);
            $qualityCreate = $this->qualityRepository->create($qualityValidate, (auth()->user())->id_user);
            dd($qualityCreate);
            return $this->responseOk("Control quality save", $qualityCreate);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
        }
    
}
