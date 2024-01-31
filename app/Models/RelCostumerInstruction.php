<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RelCostumerInstruction extends Model
{
    use HasFactory;

    protected $table = 'rel_costumer_instruction';
    protected $fillable = [
        'costumer_id',
        'title',
        'instructions'
    ];

    public function costumers():BelongsTo
    {
        return $this->belongsTo(Customers::class,'customer_id');
    }

    public function relBoutiqueCustomerInstructions():HasMany
    {
        return $this->hasMany(RelBoutiqueCustomerInstructions::class,'rel_cus_ins_id');
    }

}
