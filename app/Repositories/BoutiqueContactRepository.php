<?php

namespace App\Repositories;

use App\Interfaces\BoutiqueContactRepositoryInterface;
use App\Models\BoutiqueContacts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BoutiqueContactRepository implements BoutiqueContactRepositoryInterface{

    /**
     * Show boutiques contact per boutique
     * @param $boutiqueId
     * @return Model
     * @author LeoGiraldoQ
     */
    public function listContacPerBoutique($boutiqueId){
        return BoutiqueContacts::where('boutique_id',$boutiqueId)->with(['boutique'])->get();
    }
    
    /**
     * Create contacts for a boutique
     * @param $newBoutiqueContact,$boutique
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newBoutiqueContact,$boutiqueId){
        $storeBoutiqueContacts = array();
        foreach($newBoutiqueContact as $contactBoutique){
            $contactBoutique['boutique_id'] = $boutiqueId;
            $contactBoutique['created_at'] = Carbon::now()->toDateString();
            $storeBoutiqueContacts[] = $contactBoutique;
        }
        //return BoutiqueContacts::insert($storeBoutiqueContacts);
        DB::table('boutiques_contacts')->insert($storeBoutiqueContacts);
        return $this->listContacPerBoutique($boutiqueId);
    }
}