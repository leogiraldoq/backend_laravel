<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modules extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $primaryKey = 'id_module';
    protected $fillable = [
        'module_name',
        'description'
    ];

    public function rel_profile_module():HasMany
    {
        return $this->hasMany(RelProfileModule::class,'module_id');
    }
    
    public function profiles():BelongsToMany
    {
        return $this->belongsToMany(Profile::class,'rel_profile_module','module_id','profile_id')->withPivot('read','create','update','delete');
    }

}
