<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelBoutiqueCustomerInstructions extends Model
{
    use HasFactory;
    
    protected $table="rel_boutique_customer_intructions";
    protected $fillable=[
        "boutique_id",
        "rel_cus_ins_id"
    ];
    
    public function relCustomerIntructions():BelongsTo
    {
        return $this->belongsTo(RelCostumerInstruction::class,'rel_cus_ins_id');
    }
    
    public function boutiques(): BelongsTo 
    {
        return $this->belongsTo(Boutiques::class,'boutique_id');
    }
}
