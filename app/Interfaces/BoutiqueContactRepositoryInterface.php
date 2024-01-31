<?php

namespace App\Interfaces;

interface BoutiqueContactRepositoryInterface
{
    public function listContacPerBoutique($boutiqueId);
    public function create($newContactBoutique,$boutiqueId);
}