<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    protected $primaryKey = 'id_profile';
    protected $fillable=[
        'name',
        'description',
        'menu_bsp',
        'menu_admin'
    ];

    public function rel_user_profile():HasMany
    {
        return $this->hasMany(RelUserProfile::class,'profile_id');
    }

    public function rel_profile_module():HasMany
    {
        return $this->hasMany(RelProfileModule::class,'profile_id');
    }
    
    public function modules():BelongsToMany
    {
        return $this->belongsToMany(Modules::class,'rel_profile_module','profile_id','module_id')->withPivot('read','create','update','delete');
    }
    
    public function users():BelongsToMany
    {
        return $this->belongsToMany(Users::class,'rel_user_profile','profile_id','user_id');
    }
}
