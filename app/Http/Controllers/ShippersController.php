<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ShippersRepositoryInterface;
use App\Interfaces\CustomerNoProcessRepositoryInterface;
use App\Traits\ResponseTrait;

class ShippersController extends Controller
{
    use ResponseTrait;
    
    private ShippersRepositoryInterface $shipperRepository;
    private CustomerNoProcessRepositoryInterface $customerNotProcessRepository;
    
    public function __construct(
            ShippersRepositoryInterface $shipperRepository,
            CustomerNoProcessRepositoryInterface $customerNotProcessRepository
            
    ) {
        $this->shipperRepository = $shipperRepository;
        $this->customerNotProcessRepository = $customerNotProcessRepository;
    }
    
    /**
     * List all shippers
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
    */
    public function listAll(){
        try {
            $shippers = $this->shipperRepository->listAll();
            return $this->responseOk("Shippers listed", $shippers);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
    
    /**
     * Create shops
     * @param Object $newShipper Object new shop
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(Request $newShipper){
        try{
            $validateShop = $newShipper->validate([
                'name' => 'required|unique:shippers|min:2|max:250',
                'contactName' => 'nullable|min:5|max:250',
                'contactNumber' => 'nullable|min:5|max:250',
                'email' => 'nullable|email|min:10|max:250'
            ]);
            $shop = $this->shipperRepository->create($validateShop);
            return $this->responseOk("Shop <b>".$shop['name']."<`/b> create", $shop);
        } catch (\Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
    
    public function update(Request $shipper){
        try{
            $validateShop = $shipper->validate([
                'id' => 'required|integer',
                'name' => 'required|string|min:2|max:250',
                'contactName' => 'nullable|min:5|max:250',
                'contactNumber' => 'nullable|min:5|max:250',
                'email' => 'nullable|email|min:10|max:250'
            ]);
            $shop = $this->shipperRepository->update($validateShop);
            return $this->responseOk("Shop <b>".$shop['name']."</b> was update", $shop);
        } catch (\Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
    
    public function changeStatus($status,$idStore){
        try{
            $shop = $this->shipperRepository->changeStatus($idStore, $status);
            return $this->responseOk("Shop <b>".$shop['name']."</b> changed", $shop);
        } catch (Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
    
    
    /**
     * List shippers that will not be not process and shippers that will be not process per customer
     * @param Integer $id Customers id
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function listProcessNotProcess($id){
        try{
            $shippersList = [
                "process" => $this->shipperRepository->listProcess($id),
                "not_process" => $this->customerNotProcessRepository->listPerCustomer($id)
            ];
            return $this->responseOk("Shippers listed", $shippersList);
        } catch (\Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
    
    
    /**
     * Verify it customer and shipper its process or not
     * @param Integer $idCustomer Customer id
     * @param Integer $idShipper Shipper id
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
    */
    public function processOrNot($idCustomer,$idShipper){
        try {
            $processOrNot = $this->customerNotProcessRepository->verifyIfProcees($idCustomer, $idShipper);
            return $this->responseOk("Shop process", $processOrNot);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}
