<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'id_employee';
    protected $fillable = [
        'names',
        'last_names',
        'phone',
        'email',
        'title',
        'address',
        'city',
        'postal_code',
        'birth',
        'active'
    ];

    public function user():HasOne
    {
        return $this->hasOne(Users::class,'employee_id');
    }

}
