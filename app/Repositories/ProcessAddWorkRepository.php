<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Repositories;
use App\Interfaces\ProcessAddWorkRepositoryInterface;
use App\Models\ProcessAddWork;

/**
 * Description of ProcessAddWorkRepository
 *
 * @author LeoGiraldoQ
 */
class ProcessAddWorkRepository implements ProcessAddWorkRepositoryInterface {
    
    public function showAll(){
        return ProcessAddWork::where('active',true)->get();
    }
    
}
