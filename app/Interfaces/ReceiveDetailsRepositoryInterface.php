<?php

namespace App\Interfaces;

interface ReceiveDetailsRepositoryInterface{
    public function create($newReceiveDetails);
    public function queryByDate($date);
    public function queryByIdReceieving($id);
    public function showAll();
    public function show($id);
}