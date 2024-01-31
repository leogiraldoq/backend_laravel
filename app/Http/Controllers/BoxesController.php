<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BoxesRepositoryInterface;
use App\Traits\ResponseTrait;


class BoxesController extends Controller
{
    use ResponseTrait;
    
    private BoxesRepositoryInterface $boxRepository;
    
    public function __construct(\App\Interfaces\BoxesRepositoryInterface $boxRepository) {
        $this->boxRepository = $boxRepository;
    }
    
    
    public function list(){
        try {
            $boxes = $this->boxRepository->listAll();
            return $this->responseOk("Boxes listed",$boxes);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    public function create(Request $request){
        try {
            $dataBoxValidate = $request->validate([
                'describe' => 'required|string|min:3|max:20',
                'dimensions' => 'required|string|min:2|max:10',
            ]);
            $box = $this->boxRepository->create($dataBoxValidate);
            return $this->responseOk("Box ".$box['describe']." created", $box);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
