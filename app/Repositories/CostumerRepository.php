<?php

namespace App\Repositories;

use App\Interfaces\BoutiqueContactRepositoryInterface;
use App\Interfaces\BoutiqueRepositoryInterface;
use App\Interfaces\CostumerRepositoryInterface;
use App\Models\Costumers;
use Illuminate\Database\Query\Builder;


class CostumerRepository implements CostumerRepositoryInterface{
    
    private BoutiqueRepositoryInterface $boutiqueRepository;
    private BoutiqueContactRepositoryInterface $boutiqueContactRepository;
    
    public function __construct(
        BoutiqueRepositoryInterface $boutiqueRepository,
        BoutiqueContactRepositoryInterface $boutiqueContactRepository
    ) 
    {
        $this->boutiqueRepository = $boutiqueRepository;
        $this->boutiqueContactRepository = $boutiqueContactRepository;
    }

    /**
     * List all Costumers, boutiques, boutiques_contact and pick up companies for the aññ customers
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryAll()
    {
        return Costumers::with(['boutiques', 'boutiques.boutique_contacts', 'pick_up_company'])->get();
    }

    /** 
     * List specific costumer
     * @param $id
     * @return Model
     * @author LeoGiraldoQ
    */
    public function query($id){
        return Costumers::where('id_costumer',$id)->with(['pick_up_company','boutiques'])->firstOrFail();
    }

    /** 
     * Create costumer
     * @param $newCostumer
     * @return Model
     * @author LeoGiraldoQ
    */
    public function create($newCostumer){
        $customer = Costumers::create([
            'pick_up_company_id' => $newCostumer['pickUpCompanyId'],
            'name' => $newCostumer['name'],
            'ups_account' => $newCostumer['upsNumberAccount'],
        ]);
        foreach($newCostumer['boutiques'] as $b){
            $b['costumerId'] = $customer['id_costumer'];
            $boutique = $this->boutiqueRepository->create($b);
            $contactBoutique = $this->boutiqueContactRepository->create($b['contacts'], $boutique['id_boutique']);
        }
        return $this->query($customer['id_costumer']);
        
    }

    /**
     * Update Costumer
     * @param $updateCostumer, $id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function update($updateCostumer,$id){
        $costumer = $this->query($id);
        return tap($costumer)->update([
            'pick_up_company_id' => $updateCostumer['pickUpCompanyId'],
            'name' => $updateCostumer['name'],
            'ups_account' => $updateCostumer['upsNumberAccount'],
        ]);
    }

    /**
     * Change active column costumer
     * @param $active,$id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function changeStatus($active,$id){
        $costumer = $this->query($id);
        return tap($costumer)->update([
            'active' => $active
        ]);
    }
    
    /**
     * List all Costumers and their boutiques
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryAllAndBoutiques()
    {
        return Costumers::with(['boutiques'])->get();
    }
    
    /**
     * List all Costumers
     * @return Model
     * @author LeoGiraldoQ
     */
    public function listAllActive(){
        return Costumers::all();
    }
}