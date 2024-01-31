<?php

namespace App\Repositories;
use App\Interfaces\CustomerNoProcessRepositoryInterface;
use App\Models\CustomersNotProcess;

/**
 * Description of CustomerNotProcessRepository
 *
 * @author LeoGiraldoQ
 */
class CustomerNotProcessRepository implements CustomerNoProcessRepositoryInterface{
    
    /**
     * Create shops not process 
     * @param Object $notProcess
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($notProcess){
        return CustomersNotProcess::create([
            "customer_id" => $notProcess['customerId'],
            "shipper_id" => $notProcess['shopNoProcess'],
        ]);        
    }
    
    /**
     * List all shops to not process per customer
     * @param Integer $id Customer Id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function listPerCustomer($id){
        return CustomersNotProcess::with(['shipper'])->where("customer_id",$id)->get();
    }
    
    /**
     * Delete record from table
     * @param Integer $idCusNotPros Id from record to delete for the table customer_not_process
     * @return Model
     * @author LeoGiraldoQ
     */
    public function delete($id){
        return CustomersNotProcess::where('id',$id)->delete();
    }
    
    /**
     * VErify if the shipper and the customer is process or not
     * @param Integer $idCustomer Customer id 
     * @param Integer  $idShipper Shipper id
     * @return Model
     * @author LeoGiraldoQ
     */
    public function verifyIfProcees($idCustomer,$idShipper){
        return CustomersNotProcess::with(['customer','shipper'])->where([
                ['customer_id','=',$idCustomer],
                ['shipper_id','=',$idShipper]
            ])->get();
    }
    
}
