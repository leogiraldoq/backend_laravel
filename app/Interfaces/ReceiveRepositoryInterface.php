<?php

namespace App\Interfaces;

interface ReceiveRepositoryInterface{
    public function create($newRecibe);
    public function queryByDate($date);
    public function showAll();
}