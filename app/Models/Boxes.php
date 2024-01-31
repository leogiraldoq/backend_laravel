<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boxes extends Model
{
    use HasFactory;
    
    protected $table="boxes";
    protected $primaryKey="id_box";
    protected $fillable=[
        'describe',
        'dimensions',
        'active'
    ];
    
    public function receive_details():HasMany{
        return $this->hasMany(ReceiveDetails::class,'box_id');
    }
}
