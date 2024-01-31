<?php
namespace App\Repositories;

use App\Interfaces\BoutiqueRepositoryInterface;
use App\Models\Boutiques;

class BoutiqueRepository implements BoutiqueRepositoryInterface{

    /**
     * List all Boutiques  per Costumer
     * @param $idCostumer
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryAllForCostumer($idCostumer)
    {
        return Boutiques::where('costumer_id',$idCostumer)->with(['costumer'])->get();
    }

    /**
     * List specific Boutiques
     * @param $idBoutique
     * @return Model
     * @author LeoGiraldoQ
     */
    public function query($id)
    {
        return Boutiques::where('id_boutique',$id)->with(['costumer','pick_up_company'])->firstOrFail();
    }

    /**
     * List especific Boutiques
     * @param $idBoutique
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryBoutiqueAndContact($idBoutique)
    {
        return Boutiques::where('id_boutique',$idBoutique)->with(['boutique_contacts'])->firstOrFail();
    }

    /**
     * Create Boutiques
     * @param $idBoutique
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newBoutique)
    {
        return Boutiques::create([
            'costumer_id' => $newBoutique['costumerId'],
            'name' => $newBoutique['name'],
            'address' => $newBoutique['address'],
            'city' => $newBoutique['city'],
            'final_destination' => $newBoutique['final_destination']
        ]);
    }

    /**
     * Update Boutiques
     * @param $updateBoutique,$idBoutique
     * @return Model
     * @author LeoGiraldoQ
     */ 
    public function update($updateBoutique,$idBoutique){
        $boutique = Boutiques::where('id_boutique',$idBoutique)->firstOrFail();
        return tap($boutique)->update([
            'name' => $updateBoutique['name'],
            'address' => $updateBoutique['address'],
            'city' => $updateBoutique['city']
        ]);
    }
    
    /**
     * Return boutiques with instructions to process
     * @param Integer $idCustomer Integer with the id customer to search
     * @return Model 
     * @author LeoGiraldoQ
     */
    public function boutiquesInstructions($idCustomer){
        $boutiquesIntructions = Boutiques::where('costumer_id',$idCustomer)->with([
            'costumer',
            'relBoutiqueCustomerInstructions',
            'relBoutiqueCustomerInstructions.relCustomerIntructions'
        ])->get()->toArray();
        $boutiquesResume = array();
        $boutiquesResume['originalResult'] = $boutiquesIntructions;
        $boutiquesResume['resume'] = array();
        foreach($boutiquesIntructions as $boutique){
            $boutiquesResume['customer'] = $boutique['costumer']['name'];
            foreach($boutique['rel_boutique_customer_instructions'] as $instructions){
                $orderData['id'] = $boutique['id_boutique'];
                $orderData['name'] = $boutique['name'];
                $orderData['id_rel'] = $instructions['id'];
                $orderData['id_instruction'] = $instructions['rel_customer_intructions']['id'];
                $orderData['instructions'] = $instructions['rel_customer_intructions']['instructions'];
                $orderData['title'] = json_decode($instructions['rel_customer_intructions']['instructions'])->title;
                $orderData['sampleImage'] = json_decode($instructions['rel_customer_intructions']['instructions'])->sampleImage;
                array_push($boutiquesResume['resume'], $orderData);
            }
        }
        return $boutiquesResume;
    }
    

}