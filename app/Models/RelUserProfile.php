<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelUserProfile extends Model
{
    use HasFactory;

    protected $table = 'rel_user_profile';
    protected $fillable = [
        'user_id',
        'profile_id'
    ];

    public function users():BelongsTo
    {
        return $this->belongsTo(Users::class,'user_id');
    }

    public function profile():BelongsTo
    {
        return $this->belongsTo(Profile::class,'profile_id');
    }
}
