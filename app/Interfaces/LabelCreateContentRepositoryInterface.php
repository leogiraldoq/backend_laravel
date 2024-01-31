<?php

namespace App\Interfaces;

interface LabelCreateContentRepositoryInterface{
    public function queryAllActive();
    public function create($newLabelContent);
}