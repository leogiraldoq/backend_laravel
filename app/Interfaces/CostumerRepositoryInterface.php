<?php

namespace App\Interfaces;

interface CostumerRepositoryInterface{

    public function queryAll();
    public function query($id);
    public function create($newCostumer);
    public function update($updateCostumer,$id);
    public function changeStatus($active,$id);
    public function queryAllAndBoutiques();
    public function listAllActive();

}