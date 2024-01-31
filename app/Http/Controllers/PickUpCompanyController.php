<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePickUpCompanyRequest;
use App\Interfaces\PickUpCompanyRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PickUpCompanyController extends Controller
{
    //Traits
    use ResponseTrait;

    //Repositories
    private PickUpCompanyRepositoryInterface $pickUpCompanyRepository;

    public function __construct(PickUpCompanyRepositoryInterface $pickUpCompanyRepository)
    {
        $this->pickUpCompanyRepository = $pickUpCompanyRepository;
    }

    /**
     * Query All Pick Up Company
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function list(){
        try{
            $pickUpCompanies = $this->pickUpCompanyRepository->queryAll();
            return $this->responseOk("Pick up companies list",$pickUpCompanies);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Query one Pick Up Company
     * @param $id_pick_up_company
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function show(int $id){
        try{
            $pickUpCompany = $this->pickUpCompanyRepository->query($id);
            return $this->responseOk("Pick up company ".$pickUpCompany['name']." show",$pickUpCompany);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Create Pick Up Company
     * @param $pickUpCompany
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(CreatePickUpCompanyRequest $request){
        try {
            $newPickUpCompany = $request->validated();
            $pickUpCompany = $this->pickUpCompanyRepository->create($newPickUpCompany);
            return $this->responseOk("Pick up company ".$pickUpCompany['name']." was create",$pickUpCompany);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Update Pick Up Company
     * @param $pickUpCompany, $id_pick_up_company
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function update(CreatePickUpCompanyRequest $request,int $id){
        try {
            $updatePickUpCompany = $request->validated();
            $pickUpCompany = $this->pickUpCompanyRepository->update($updatePickUpCompany,$id);
            return $this->responseOk("Pick up company ".$pickUpCompany['update']." was update.",$pickUpCompany);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Change status active Pick Up Company
     * @param $active, $id_pick_up_company
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function changeStatus(Request $request, int $id){
        try {
            $statusPickUpCompany = $request->validate([
                "active" => "boolean|required"
            ]);
            $pickUpCompany = $this->pickUpCompanyRepository->change($request->input('active'),$id);
            return $this->responseOk("Pick up company ".$pickUpCompany['update']." was update status.",$pickUpCompany); 
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}   
