<?php

namespace App\Interfaces;

/**
 *
 * @author LeoGiraldoQ
 */
interface RelProfileModuleRepositoryInterface {
    public function create($idProfile,$newRelProfileModule);
    public function upsert($idProfile,$dataRelProfileModule);
}
