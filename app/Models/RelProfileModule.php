<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelProfileModule extends Model
{
    use HasFactory;

    protected $table = 'rel_profile_module';
    protected $fillable = [
        'profile_id',
        'module_id',
        'read',
        'create',
        'update',
        'delete'
    ];

    public function profile():BelongsTo
    {
        return $this->belongsTo(Profile::class,'profile_id');
    }

    public function modules():BelongsTo
    {
        return $this->belongsTo(Modules::class,'module_id');
    }
}
