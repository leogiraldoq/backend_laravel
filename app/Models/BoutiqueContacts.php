<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoutiqueContacts extends Model
{
    use HasFactory;

    protected $table = 'boutiques_contacts';
    protected $primaryKey = 'id_boutique_contact';
    protected $fillable = [
        'boutique_id',
        'contact_name',
        'phone',
        'email'
    ];

    public function boutique():BelongsTo{
        return $this->belongsTo(Boutiques::class,'id_boutique');
    }
}

