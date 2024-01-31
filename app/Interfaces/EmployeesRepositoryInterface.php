<?php

namespace App\Interfaces;

interface EmployeesRepositoryInterface
{
    public function queryAll();
    public function query($id);
    public function create($newEmployee);
    public function update($updateEmployee,$id);
    public function change($active,$id);
}