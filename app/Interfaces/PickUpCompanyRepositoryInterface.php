<?php

namespace App\Interfaces;

interface PickUpCompanyRepositoryInterface
{
    public function queryAll();
    public function query($id);
    public function create($newPickUpCompany);
    public function update($updatePickUpCompany,$id);
    public function change($active,$id);
}