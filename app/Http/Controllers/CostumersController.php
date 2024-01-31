<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateCostumerRequest;
use App\Interfaces\CostumerRepositoryInterface;
use App\Interfaces\CustomerNoProcessRepositoryInterface;
use App\Interfaces\ShippersRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CostumersController extends Controller
{
    //Traits
    use ResponseTrait;

    //Repositories
    private CostumerRepositoryInterface $costumerRepository;
    private CustomerNoProcessRepositoryInterface $customerNotProcessRepository;
    private ShippersRepositoryInterface $shippersRepository;
    

    public function __construct(
            CostumerRepositoryInterface $costumerRepository,
            CustomerNoProcessRepositoryInterface $customerNotProcessRepository,
            ShippersRepositoryInterface $shippersRepository
        )
    {
        $this->costumerRepository = $costumerRepository;
        $this->customerNotProcessRepository = $customerNotProcessRepository;
        $this->shippersRepository = $shippersRepository;
    }

    /**
     * List all costumers, boutiques, contact boutique and pick up company
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function listAll(){
        try{
            $costumers = $this->costumerRepository->queryAll();
            return $this->responseOk("Costumers listed",$costumers);
        }catch(\Throwable $th){
            return $this->responseError($th->getMessage());
        }
    }

    /**
     * List specific costumer
     * @param $id_costumer
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function show(int $id){
        try {
            $costumer = $this->costumerRepository->query($id);
            return $this->responseOk("Costumer ".$costumer['name']." listed",$costumer);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    /**
     * Create a costumer
     * @param $newCostumer
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(CreateUpdateCostumerRequest $request){
        try {
            $newCostumer = $request->validated();
            $costumer = $this->costumerRepository->create($newCostumer);
            return $this->responseOk("Costumer ".$costumer['name']." was create",$costumer);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    /**
     * Update costumer
     * @param $updateCostumer , $id
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function update(CreateUpdateCostumerRequest $request,int $id){
        try {
            $updateCostumer = $request->validated();
            $costumer = $this->costumerRepository->update($updateCostumer,$id);
            return $this->responseOk("Costumer ".$costumer['name']." was update",$costumer);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    /**
     * Change status active costumer
     * @param $active , $id
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function changeStatus(Request $request,$id){
        try {
            $request->validate([
                'active' => 'required|boolean'
            ]);
            $costumer = $this->costumerRepository->changeStatus($request->input('active'),$id);
            return $this->responseOk("Costumer ".$costumer['name']." changed status",$costumer);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
    
    /**
     * List all costumers and boutiques
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function listAllAndBoutiques(){
        try{
            $costumers = $this->costumerRepository->queryAllAndBoutiques();
            return $this->responseOk("Costumers listed",$costumers);
        }catch(\Throwable $th){
            return $this->responseError($th->getMessage());
        }
    }
    
    /**
     * List all costumers where active is true
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function listAllActive(){
        try{
            $costumers = $this->costumerRepository->listAllActive();
            return $this->responseOk("Costumers listed",$costumers);
        }catch(\Throwable $th){
            return $this->responseError($th->getMessage());
        }
    }
    
    /**
     * Create the relation between customer and shippers to not process
     * @param Object $notProcess Object two element customerId and Array of shippers to not process
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function createShopNotProcess(Request $notProcess){
        try {
            $valProcess = $notProcess->validate([
               "customerId" => "required|integer",
               "shopNoProcess" => "required|integer",
            ]);
            $shopsNotProcess = $this->customerNotProcessRepository->create($valProcess);
            $shippersList = (new ShippersController($this->shippersRepository,$this->customerNotProcessRepository))->listProcessNotProcess($valProcess['customerId']);
            return $shippersList;
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    /**
     * Create the relation between customer and shippers to not process
     * @param Object $notProcess Object two element customerId and Array of shippers to not process
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function listShipperNotProcess($id){
        try {
            $shopsNotProcess = $this->customerNotProcessRepository->listPerCustomer($id);
            return $this->responseOk("Shops not process listed", $shopsNotProcess);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
    /**
     * Remove shop to not process
     * @param Integer $id Customer not process id
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method DELETE
     */
    public function deleteShopNotProcess(Request $shopCustomerDelete){
        try {
            $valDeleteNotProcess = $shopCustomerDelete->validate([
               "customerId" => "required|integer",
               "idCustomerShopNot" => "required|integer",
            ]);
            $deleteShopNotProcess = $this->customerNotProcessRepository->delete($valDeleteNotProcess['idCustomerShopNot']);
            $shippersList = (new ShippersController($this->shippersRepository,$this->customerNotProcessRepository))->listProcessNotProcess($valDeleteNotProcess['customerId']);
            return $shippersList;
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
}

