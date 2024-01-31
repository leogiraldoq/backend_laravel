<?php
namespace App\Repositories;

use App\Interfaces\RelUserProfileRepositoryInterface;
use App\Models\RelUserProfile;

class RelUserProfileRepository implements RelUserProfileRepositoryInterface{
    
    /**
     * Create relation profiles for user
     * @param Integer $idUser User id
     * @param Array $profiles Profiles to be assign to user
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($idUser,$profiles){
        foreach($profiles as $profile){
            $createRelProfile[]=RelUserProfile::create([
                'user_id' => $idUser,
                'profile_id' => $profile
            ]);
        }
        return $createRelProfile;
    }
}
