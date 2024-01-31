<?php

namespace App\Repositories;

use App\Interfaces\ProfilesRepositoryInterface;
use App\Models\Profile;
use App\Interfaces\RelProfileModuleRepositoryInterface;

class ProfilesRepository implements ProfilesRepositoryInterface{
    
    private RelProfileModuleRepositoryInterface $relProfileModuleRepository;
    
    public function __construct(RelProfileModuleRepositoryInterface $relProfileModuleRepository) {
        $this->relProfileModuleRepository = $relProfileModuleRepository;
    }
    
    /**
     * Query all profiles
     * @return Model
     * @author LeoGiraldoQ
     */
    public function showAll(){
        return Profile::with(['modules'])->get();
    }
    
    /**
     * Query all profiles
     * @return Model
     * @author LeoGiraldoQ
     */
    public function show($id){
        return Profile::where('id_profile',$id)->with(['rel_profile_module','modules'])->firstOrFail();
    }
    
    /**
     * Create Profile
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newData){
        $profile = Profile::create([
            'name' => $newData['name'],
            'description' => $newData['description']
        ]);
        $relProfileModules = $this->relProfileModuleRepository->create($profile['id_profile'], $newData['modulesPermissions']);
        $profile['relProfileModules'] = $relProfileModules;
        return $profile;
    }
    
    /**
     * Update Profile
     * @return Model
     * @author LeoGiraldoQ
     */
    public function update($updateData){
        $profile = $this->show($updateData['id']);
        return tap($profile)->update([
            'profile_name' => $updateData['profileName'],
            'description' => $updateData['profileDescription']            
        ]);
    }

}
