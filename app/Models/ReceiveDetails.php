<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceiveDetails extends Model
{
    use HasFactory;
    
    protected $table = 'receive_details';
    protected $primaryKey = 'id_receive_detail';
    protected $fillable=[
        'receive_id',
        'boutique_id',
        'box_id',
        'quantity_box',
        'weight_box'
    ];
    
    public function receive():BelongsTo {
        return $this->belongsTo(Receive::class,'receive_id');
    }
    
    public function boutiques():BelongsTo{
        return $this->belongsTo(Boutiques::class, 'boutique_id');
    }
    
    public function boxes():BelongsTo{
        return $this->belongsTo(Boxes::class,'box_id');
    }
    
    public function pre_billing():HasOne{
        return $this->hasOne(PreBilling::class,'receive_details_id');
    }
    
    public function quality():HasMany{
        return $this->hasMany(Quality::class,'receive_details_id');
    }
}
