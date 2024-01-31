<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBoutiqueRequest;
use App\Http\Requests\CreateBoutiqueRequest;
use App\Interfaces\BoutiqueContactRepositoryInterface;
use App\Interfaces\BoutiqueRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoutiquesController extends Controller
{
    //Traits
    use ResponseTrait;

    //Repositories
    private BoutiqueRepositoryInterface $boutiqueRespository;
    private BoutiqueContactRepositoryInterface $boutiqueContactRepository;

    public function __construct(
        BoutiqueRepositoryInterface $boutiqueRespository,
        BoutiqueContactRepositoryInterface $boutiqueContactRepository)
    {
        $this->boutiqueRespository = $boutiqueRespository;
        $this->boutiqueContactRepository = $boutiqueContactRepository;
    }

    /**
     * List all boutiques per costumers
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function listAllPerCostumer($idCostumer){
        try{
            $boutiques = $this->boutiqueRespository->queryAllForCostumer($idCostumer);
            return $this->responseOk("Boutiques listed for costumer ".$boutiques[0]['costumer']['name'],$boutiques);
        }catch(\Throwable $th){
            return $this->responseError($th->getMessage());
        }
    }

    /**
     * List especific boutique
     * @param $id_boutique
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function show(int $id){
        try {
            $boutique = $this->boutiqueRespository->query($id);
            return $this->responseOk("Boutique ".$boutique['name']." listed",$boutique);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    /**
     * Create a new boutique
     * @param $newBoutique
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(CreateBoutiqueRequest $request){
        try {
            $newBoutique = $request->validated();
            $boutique = $this->boutiqueRespository->create($newBoutique);
            $boutique['boutiques_contacts'] = $this->boutiqueContactRepository->create($newBoutique['contact'],$boutique['id_boutique']);
            return $this->responseOk("Boutique ".$boutique['name']." was create",$boutique);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    /**
     * Update a boutique
     * @param $updateBoutique
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function update(UpdateBoutiqueRequest $resquest,$id){
        try {
            $updateBoutique = $request->validated();
            $boutique = $this->boutiqueRespository->update($updateBoutique,$id);
            return $this->responseOk("Boutique ".$boutique['name']." was update.",$boutique);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Change status for a boutique
     * @param $active,$id
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function changeStatus(Request $request,$id){
        try {
            $request->validate([
                "active" => "boolean|required"
            ]);
            $boutique = $this->boutiqueRespository->changeStatus($active,$id);
        } catch (\Exception $e) {
            
        }
    }

    /**
     * Boutiques per customer with instructions
     * @param Integer $idCustomer Customer id
     * @return JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function instructions($idCustomer){
        try{
            $boutiques = $this->boutiqueRespository->boutiquesInstructions($idCustomer);
            return $this->responseOk("Boutiques Instructions listed", $boutiques);
        } catch (\Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
}
