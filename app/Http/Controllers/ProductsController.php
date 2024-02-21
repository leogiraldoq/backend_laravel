<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductsRepositoryInterface;
use App\Traits\ResponseTrait;

class ProductsController extends Controller
{
    use ResponseTrait;
    
    private ProductsRepositoryInterface $productRepository;
    
    public function __construct(ProductsRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }
    
    public function show(){
        try {
            $products = $this->productRepository->show();
            return $this->responseOk("Products listed", $products);
        } catch (Exception $exc) {
            return $this->responseError($exc);
        }
    }
    
    public function showBoxes(){
        try {
            $products = $this->productRepository->showWithBoxes();
            return $this->responseOk("Products listed", $products);
        } catch (Exception $exc) {
            return $this->responseError($exc);
        }
    }
    
    public function showWithBoxes(){
        try {
            $productBoxes = $this->productRepository->queryByBoxes();
            $products = $this->productRepository->show();
            return $this->responseOk("Products and boxes listed", [
                "resume" => $productBoxes,
                "products" => $products
            ]);
        } catch (Exception $exc) {
            return $this->responseError($exc);
        }
    }
    
    public function create(Request $product){
        try {
            $productValidate = $product->validate([
                "name" => "required|string|min:3|max:100"
            ]);
            $productCreate = $this->productRepository->create($productValidate["name"]);
            return $this->responseOk("Product ".$productCreate["name"]." was created", $productCreate);
        } catch (Exception $exc) {
            return $this->responseError($exc);
        }
    }
}
