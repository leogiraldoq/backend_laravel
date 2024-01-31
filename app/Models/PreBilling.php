<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PreBilling extends Model
{
    use HasFactory;
    
    protected $table = "pre_billing";
    protected $primaryKey = "id_pre_bill";
    protected $fillable = [
        "receive_details_id",
        "invoice_number",
        "quantity_styles",
        "total_pieces",
        "photo_invoice",
        "user_id"
    ];
    
    public function receive_details():BelongsTo
    {
        return $this->belongsTo(ReceiveDetails::class,'receive_details_id');
    }
    
    public function processing():HasMany{
        return $this->hasMany(Processing::class,"pre_bill_id");
    }
    
    public function users():BelongsTo{
        return $this->belongsTo(Users::class,'user_id');
    }
}
