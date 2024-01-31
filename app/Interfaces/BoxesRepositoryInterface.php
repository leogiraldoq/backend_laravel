<?php

namespace App\Interfaces;

interface BoxesRepositoryInterface {
    public function listAll();
    public function create($newBox);
}
