<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateEmployeesRequest;
use App\Interfaces\EmployeesRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    //Traits
    use ResponseTrait;

    //Repositories
    private EmployeesRepositoryInterface $employeeRepository;


    public function __construct(EmployeesRepositoryInterface $employeeRepository){
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Query All Employees
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function list(){
        try{
            $employees = $this->employeeRepository->queryAll();
            return $this->responseOk("All Employees list",$employees);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Query one Employees
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method GET
     */
    public function show(int $id){
        try{
            $employees = $this->employeeRepository->query($id);
            return $this->responseOk("All Employees list",$employees);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * Create Employee
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method POST
     */
    public function create(CreateUpdateEmployeesRequest $request){
        try{
            $request->validated();
            $employee = $this->employeeRepository->create($request->all());
            return $this->responseOk("Employee ".$employee['names']." ".$employee['last_names']." was create",$employee);
        }catch(\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Update Employee
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function update(CreateUpdateEmployeesRequest $request, int $id){
        try{
            $updateEmployee = $request->validated();
            $employee = $this->employeeRepository->update($updateEmployee,$id);
            return $this->responseOk("Employee ".$employee['names']." ".$employee['last_names']." was update" , $employee);
        }catch(\Exception $e){
            $this->responseError($e->getMessage());
        }
        
    }

    /**
     * Active or Inactive Employee
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     * @method PUT
     */
    public function changeStatus(Request $request,int $id){
        try{
            $activeEmployee = $request->validate([
                "active" => "boolean|required"
            ]);
            $employee = $this->employeeRepository->change($request->input('active'),$id);
            return $this->responseOk("Employee ".$employee['names']." ".$employee['last_names']." was change status" , $employee);
        }catch(\Exception $e){
            $this->responseError($e->getMessage());
        }
        
    }

}
