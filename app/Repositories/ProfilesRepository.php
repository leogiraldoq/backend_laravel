<?php

namespace App\Repositories;

use App\Interfaces\ProfilesRepositoryInterface;
use App\Models\Profile;
use App\Models\Modules;
use App\Models\RelUserProfile;
use App\Interfaces\RelProfileModuleRepositoryInterface;
use App\Interfaces\ModulesRepositoryInterface;

class ProfilesRepository implements ProfilesRepositoryInterface{
    
    private RelProfileModuleRepositoryInterface $relProfileModuleRepository;
    private ModulesRepositoryInterface $moduleRepository;
    
    public function __construct(
            RelProfileModuleRepositoryInterface $relProfileModuleRepository,
            ModulesRepositoryInterface $moduleRepository
        ) {
        $this->relProfileModuleRepository = $relProfileModuleRepository;
        $this->moduleRepository = $moduleRepository;
    }
    
    /**
     * Query all profiles
     * @return Model
     * @author LeoGiraldoQ
     */
    public function showAll(){
        return Profile::with(['modules'])->get();
    }
    
    public function index($idProfile){
        $proofileModule = Profile::with(['modules'])->where('id_profile',$idProfile)->get()->toArray();
        $dataOrdered = array();
        $dataOrdered["id_profile"] = $proofileModule[0]['id_profile'];
        $dataOrdered["name"] = $proofileModule[0]['name'];
        $dataOrdered["description"] = $proofileModule[0]['description'];
        $dataOrdered["menuBsp"] = json_decode($proofileModule[0]['menu_bsp']);
        $dataOrdered["menuAdmin"] = json_decode($proofileModule[0]['menu_admin']);
        $dataOrdered["modulesPermissions"] = $this->orderModules($proofileModule[0]['modules']);
        return $dataOrdered;
    }
    
    private function orderModules($modulesNow){
        $modules = $this->moduleRepository->showAll()->toArray();
        $res = array();
        foreach ($modules as $key=>$module){
            $itsInArray = array_map(function($n) use ($module){
                if($n['module_name'] == $module['module_name'] && $n['id_module'] == $module['id_module']){
                    return $n;
                }
            }, $modulesNow);
            if($itsInArray[$key] !== null){
                array_push($res,[
                    "id_module" => $itsInArray[$key]['id_module'],
                    "module_name" => $itsInArray[$key]['module_name'],
                    "create" => ($itsInArray[$key]['pivot']['create'] == 1 ? true : false),
                    "read" => ($itsInArray[$key]['pivot']['read'] == 1 ? true : false),
                    "update" => ($itsInArray[$key]['pivot']['update'] == 1 ? true : false),
                    "erase" => ($itsInArray[$key]['pivot']['delete'] == 1 ? true : false),
                ]);    
            }else{
                array_push($res,[
                    "id_module" => $module['id_module'],
                    "module_name" => $module['module_name'],
                    "create" => false,
                    "read" => false,
                    "update" => false,
                    "erase" => false,
                ]);
            }
        }
        return $res;
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
            'description' => $newData['description'],
            'menu_bsp' => json_encode($newData['menuBsp']),
            'menu_admin' => json_encode($newData['menuAdmin']),

        ]);
        $relProfileModules = $this->relProfileModuleRepository->create($profile['id_profile'], $newData['modulesPermissions']);
        $profile['relProfileModules'] = $relProfileModules;
        return $profile;
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
    
    public function showMenuUser($idUser){
        $moduleUsers = RelUserProfile::where('user_id',$idUser)->with(['profile',])->get()->toArray();
        $menuUser = array();
        $menuUser['Bsp'] = $moduleUsers[0]['profile']['menu_bsp'];
        $menuUser['Admin'] = $moduleUsers[0]['profile']['menu_admin'];
        return $menuUser;
    }

    public function update($profile){
        $updateProfile = Profile::where('id_profile',$profile['id_profile'])->update([
            'name' => $profile['name'],
            'description' => $profile['description'],
            'menu_bsp' => json_encode($profile['menuBsp']),
            'menu_admin' => json_encode($profile['menuAdmin']),

        ]);
        $relProfileModules = $this->relProfileModuleRepository->upsert($profile['id_profile'], $profile['modulesPermissions']);
        //$updateProfile['relProfileModules'] = $relProfileModules;
        return $updateProfile;
    }
}
