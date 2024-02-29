<?php

namespace App\Repositories;

use App\Interfaces\ProfilesRepositoryInterface;
use App\Models\Profile;
use App\Models\Modules;
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

    
    public function showUsersProfile($module){
        $moduleUsers = Modules::with(['profiles','profiles.users','profiles.users.employee'])->where("module_name",$module)->get()->toArray();
        $usersModule = array();
        foreach($moduleUsers as $module){
            foreach ($module['profiles'] as $profile){
                foreach ($profile['users'] as $user){
                    array_push($usersModule,[
                        "userId" => $user['id_user'],
                        "names" => $user['employee']['names']
                    ]);
                }   
            }
        }
        return $usersModule;

    }
}
