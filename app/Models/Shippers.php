<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shippers extends Model
{
    use HasFactory;
    
    protected $table='shippers';
    protected $primaryKey='id_shipper';
    protected $fillable=[
        'name',
        'contact_name',
        'contact_number',
        'email',
        'active'
    ];
    
    public function recibe():HasMany
    {
        return $this->hasMany(Receive::class, 'shipper_id', 'id_shipper');
    }
    
    public function customer_not_process():HasMany
    {
        return $this->hasMany(CustomersNotProcess::class,'shipper_id');
    }
    
    public function rel_pack_stores():HasMany{
        return $this->hasMany(RelPackingStore::class, 'shipper_id');
    }
}
