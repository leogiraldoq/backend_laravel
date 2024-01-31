<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceiveSupports extends Model
{
    use HasFactory;
    protected $table="receive_supports";
    protected $fillable=[
        'receive_id',
        'ticket',
        'stickers'
    ];
    
    public function receive():BelongsTo
    {
        return $this->belongsTo(Receive::class,'receive_id');
    }
}
