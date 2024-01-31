<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Costumers extends Model
{
    use HasFactory;

    protected $table = 'costumers';
    protected $primaryKey = 'id_costumer';
    protected $fillable = [
        'pick_up_company_id',
        'name',
        'ups_account',
        'sample_instruction'
    ];

    public function boutiques():HasMany
    {
        return $this->hasMany(Boutiques::class,'costumer_id');
    }

    public function rel_customers_instructions():HasMany
    {
        return $this->hasMany(RelCustomerInstruction::class,'customer_id');
    }

    public function pick_up_company():BelongsTo
    {
        return $this->belongsTo(PickUpCompany::class,'pick_up_company_id');
    }
    
    public function labels():HasMany
    {
        return $this->hasMany(Labels::class,'customer_id');
    }
    
    public function receive():HasMany
    {
        return $this->hasMany(Receive::class, 'customer_id');
    }
    
    public function not_process():HasMany
    {
        return $this->hasMany(CustomersNotProcess::class,'customer_id');
    }
}
