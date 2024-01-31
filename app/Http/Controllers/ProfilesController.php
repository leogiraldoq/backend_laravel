<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Interfaces\ProfilesRepositoryInterface;



class ProfilesController extends Controller
{
    use ResponseTrait;
    private ProfilesRepositoryInterface $profileRepository;
    
    public function __construct(ProfilesRepositoryInterface $profileRepository) {
        $this->profileRepository = $profileRepository;
    }
    
    /**
     * List all profiles with modules and permisions (rel_profile_module)
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function listAll(){
        try {
            $allProfiles = $this->profileRepository->showAll();
            return $this->responseOk("All profiles are list", $allProfiles);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }

    /**
     * Create profile
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(Request $request){
        try {
            $validated = $request->validate([
                'name' => 'required|unique:profiles|min:4|max:20',
                'description' => 'nullable|min:10|max:255',
                'modulesPermissions' => 'required|array|min:1',
                'modulesPermissions.*.id_module' => 'required|integer|min:1',
                'modulesPermissions.*.create' => 'required|boolean',
                'modulesPermissions.*.read' => 'required|boolean',
                'modulesPermissions.*.update' => 'required|boolean',
                'modulesPermissions.*.erase' => 'required|boolean',
            ]);
            $createProfiles = $this->profileRepository->create($validated);
            return $this->responseOk("Profile ".$createProfiles['profile_name']." was create", $createProfiles);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
}