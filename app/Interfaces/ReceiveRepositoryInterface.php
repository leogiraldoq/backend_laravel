<?php

namespace App\Interfaces;

interface ReceiveRepositoryInterface{
    public function create($newRecibe);
    public function queryByDate($date);
    public function showAll();
    public function index($idReceive);
    public function delete($idB64Receive);
}