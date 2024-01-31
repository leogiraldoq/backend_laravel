<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ModulesRepositoryInterface;
use \App\Traits\ResponseTrait;

class ModulesController extends Controller
{
    use ResponseTrait;
    private ModulesRepositoryInterface $moduleRepository;
    
    public function __construct(ModulesRepositoryInterface $moduleRepository) {
        $this->moduleRepository = $moduleRepository;
    }
    
    /**
     * List all modules
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function listAll(){
        try {
            $allModules = $this->moduleRepository->showAll();
            return $this->responseOk("All modules are list", $allModules);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }

    /**
     * Create module
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(Request $request){
        try {
            $dataModuleValidate = $request->validate([
                'module_name' => 'required|unique:modules|min:5|max:20',
                'description' => 'nullable|min:10|max:250'
            ]);
            $createModule = $this->moduleRepository->create($dataModuleValidate);
            return $this->responseOk("Module ".$createModule['module_name']." created", $createModule);
        } catch (\Exception $exc) {
            return $this->responseError($exc->getMessage());
        }
    }
    
}
