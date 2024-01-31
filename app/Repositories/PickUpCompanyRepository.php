<?php

namespace App\Repositories;

use App\Interfaces\PickUpCompanyRepositoryInterface;
use App\Models\PickUpCompany;

class PickUpCompanyRepository implements PickUpCompanyRepositoryInterface{

    /**
     * List all pick up companies
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryAll(){
        return PickUpCompany::all();
    }

    /**
     * List one pick up companies
     * @param $id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function query($id){
        return PickUpCompany::where('id_pick_up_company',$id)->with(['costumer'])->firstOrFail();
    } 

    /**
     * Create pick up companies
     * @param $id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newPickUpCompany){
        return PickUpCompany::create([
            'name' => $newPickUpCompany['name'],
            'active' => true
        ]);
    }

    /**
     * Update pick up companies
     * @param $id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function update($updatePickUpCompany,$id){
        $pickUpCompany = $this->query($id);
        return tap($pickUpCompany)->update([
            'name' => $updatePickUpCompany['name']
        ]);
    }

    /**
     * Delete (update column active) PickUpCompany
     * @param $active, $id_employee
     * @return Model
     * @author LeoGiraldoQ
     */
    public function change($active,$id){
        $pickUpCompany = $this->query($id);
        return tap($pickUpCompany)->update([
            'active' => $active
        ]);
    }
}