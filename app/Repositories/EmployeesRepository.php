<?php 

namespace App\Repositories;

use App\Interfaces\UsersRepositoryInterface;
use App\Interfaces\RelUserProfileRepositoryInterface;
use App\Interfaces\EmployeesRepositoryInterface;
use App\Models\Employees;


class EmployeesRepository implements EmployeesRepositoryInterface
{
    private UsersRepositoryInterface $usersRepository;
    private RelUserProfileRepositoryInterface $relUserProfileRepository;
    
    public function __construct(
        UsersRepositoryInterface $usersRepository, 
        RelUserProfileRepositoryInterface $relUserProfileRepository
    ) {
        $this->usersRepository = $usersRepository;
        $this->relUserProfileRepository = $relUserProfileRepository;
    }
    
    /**
     * Query all Employees
     * @return Model
     * @author LeoGiraldoQ
     */
    public function queryAll()
    {
        return Employees::with(['user'])->get();
    }

    /**
     * Query Employees per id
     * @param $id_employee
     * @return Model
     * @author LeoGiraldoQ
     */
    public function query($id)
    {
        return Employees::where('id_employee',$id)->with(['user'])->first();
    }

    /**
     * Create Employee
     * @param $newEmployee object
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newEmployee)
    {
        $createEmployee = Employees::create([
            'names' => $newEmployee['names'],
            'last_names' => $newEmployee['last_names'],
            'phone' => $newEmployee['phone'],
            'email' => $newEmployee['email'],
            'title' => $newEmployee['title'],
            'address' => $newEmployee['address'],
            'city' => $newEmployee['city'],
            'postal_code' => $newEmployee['postal_code'],
            'birth' => $newEmployee['birth']
        ]);
        
        if($newEmployee['user'] == 'Yes'){
            $createEmployee['user'] = $this->usersRepository->create($createEmployee['id_employee'],$newEmployee['username'],$newEmployee['names'],$newEmployee['email']);
            if($newEmployee['profile']){
               $createEmployee['profiles'] = $this->relUserProfileRepository->create($createEmployee['user']['id_user'], $newEmployee['profile']);
            }
        }
        
        return $createEmployee;
    }

    /**
     * Update Employee
     * @param $updateEmployee, $id_employee
     * @return Model
     * @author LeoGiraldoQ
     */
    public function update($updateEmployee,$id){
        $employee = $this->query($id);
        return tap($employee)->update([
            'names' => $updateEmployee['names'],
            'last_names' => $updateEmployee['last_names'],
            'phone' => $updateEmployee['phone'],
            'email' => $updateEmployee['email'],
            'title' => $updateEmployee['title'],
            'address' => $updateEmployee['address'],
            'city' => $updateEmployee['city'],
            'postal_code' => $updateEmployee['postal_code'],
            'birth' => $updateEmployee['birth']
        ]);
    }

    /**
     * Delete (update column active) Employee
     * @param $active, $id_employee
     * @return Model
     * @author LeoGiraldoQ
     */
    public function change($active,$id){
        $employee = $this->query($id);
        return tap($employee)->update([
            'active' => $active
        ]);
    }
}