<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BoxesRepositoryInterface;
use App\Interfaces\ProductsRepositoryInterface;
use App\Traits\ResponseTrait;


class BoxesController extends Controller
{
    use ResponseTrait;
    
    private BoxesRepositoryInterface $boxRepository;
    private ProductsRepositoryInterface $productRepository;
    
    public function __construct(
            BoxesRepositoryInterface $boxRepository,
            ProductsRepositoryInterface $productRepository
    ) {
        $this->boxRepository = $boxRepository;
        $this->productRepository = $productRepository;
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
                'productId' => 'required|array',
                'dimensions' => 'required|string|min:2|max:10',
            ]);
            $box = $this->boxRepository->create($dataBoxValidate);
            $productBoxes = $this->productRepository->queryByBoxes();
            return $this->responseOk("Box created", $productBoxes);
        } catch (Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
