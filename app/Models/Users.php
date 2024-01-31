<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'employee_id',
        'username',
        'password',
        'active',
        'last_loguin'
    ];
    protected $hidden = [
        'password'
    ];


    public function employee():HasOne
    {
        return $this->hasOne(Employees::class, 'id_employee');
    }

    public function rel_user_profile():HasMany
    {
        return $this->hasMany(RelUserProfile::class,'user_id');
    }

    public function receive():HasMany{
        return $this->hasMany(Receive::class, 'user_id');
    }
    
    public function pre_billing():HasMany{
        return $this->hasMany(PreBilling::class,'user_id');
    }
    
    public function processing():HasMany{
        return $this->hasMany(Processing::class,"user_id");
    }
    
    //JWT functions
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
