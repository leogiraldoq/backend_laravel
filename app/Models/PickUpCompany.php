<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PickUpCompany extends Model
{
    use HasFactory;

    protected $table='pick_up_company';
    protected $primaryKey='id_pick_up_company';
    protected $fillable=[
        'name',
        'active'
    ];

    public function costumer():HasMany{
        return $this->hasMany(Costumers::class,'pick_up_company_id');
    }
    
    public function delivery():HasMany{
        return $this->hasMany(Delivery::class,'pickup_id');
    }
}
