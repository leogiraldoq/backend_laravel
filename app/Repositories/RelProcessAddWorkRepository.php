<?php

namespace App\Repositories;
use App\Interfaces\RelProcessAddWorkRepositoryInterface;
use App\Models\RelProcessAddWork;

/**
 * Description of RelProcessAddWorkRepository
 *
 * @author LeoGiraldoQ
 */
class RelProcessAddWorkRepository implements RelProcessAddWorkRepositoryInterface {
    
    public function create($processIds,$addWork){
        foreach($processIds as $idProc){
            foreach($addWork as $add){
                $relProcAddWork[] = RelProcessAddWork::create([
                    "process_id" => $idProc,
                    "add_work_id" => $add
                ])->id;
            }
        }
        return $relProcAddWork;
    }
}
