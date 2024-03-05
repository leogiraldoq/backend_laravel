<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Receive extends Model
{
    use HasFactory;
    
    protected $table='receive';
    protected $primaryKey='id_receive';
    protected $fillable=[
        'follow_number',
        'user_id',
        'shipper_id',
        'customer_id',
        'observations',
        'photo',
        'its_process',
    ];
    
    public function receive_details():HasMany{
        return $this->hasMany(ReceiveDetails::class,'receive_id');
    }
    
    public function shipper():BelongsTo{
        return $this->belongsTo(Shippers::class, 'shipper_id');
    }
    
    public function customer():BelongsTo{
        return $this->belongsTo(Costumers::class, 'customer_id');
    }
    
    public function user():BelongsTo{
        return $this->belongsTo(Users::class,'user_id');
    }
    
    public function receive_support():HasOne{
        return $this->hasOne(ReceiveSupports::class,'receive_id');
    }
}
