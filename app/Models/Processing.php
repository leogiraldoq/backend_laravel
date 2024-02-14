<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Processing extends Model
{
    use HasFactory;
    
    protected $table="processing";
    protected $primaryKey="id_process";
    protected $fillable=[
        "pre_bill_id",
        "style_number",
        "style_color",
        "style_total",
        "work_share",
        "user_id"
    ];
    
    public function pre_billing():BelongsTo{
        return $this->belongsTo(PreBilling::class,"pre_bill_id");
    }
    
    public function users():BelongsTo{
        return $this->belongsTo(Users::class,"user_id");
    }
    
}
