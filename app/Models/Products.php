<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    use HasFactory;
    
    protected $table = "products";
    protected $primaryKey = "id_product";
    protected $fillable = [
        "name",
        "active"
    ];
    
    public function boxes():HasMany{
        return $this->hasMany(Boxes::class,"product_id");
    }
}
