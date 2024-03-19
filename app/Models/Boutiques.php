<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boutiques extends Model
{
    use HasFactory;

    protected $table = 'boutiques';
    protected $primaryKey = 'id_boutique';
    protected $fillable = [
        'costumer_id',
        'name',
        'address',
        'city',
        'final_destination',
        'zip_address',
        'zip_final'
    ];

    public function costumer():BelongsTo
    {
        return $this->belongsTo(Costumers::class,'costumer_id');
    }

    public function boutique_contacts():HasMany
    {
        return $this->hasMany(BoutiqueContacts::class,'boutique_id');
    }
    
    public function receive_details():HasMany
    {
        return $this->hasMany(ReceiveDetails::class, 'boutique_id');
    }
    
    public function relBoutiqueCustomerInstructions():HasMany
    {
        return $this->hasMany(RelBoutiqueCustomerInstructions::class,'boutique_id');
    }
    
    public function packing():HasMany{
        return $this->hasMany(Packing::class,'boutique_id');
    }
}
