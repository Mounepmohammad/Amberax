<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class provider extends Authenticatable implements JWTSubject
{
    use HasFactory ,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'area',
        'streets',
        'feez',
        'cost_pk',
        'phone',
        'phone2',
        'photo',
        'license',
    ];

    public function clients()
    {
        return $this->hasMany(client::class , 'provider_id','id');
    }

    public function bills()
    {
        return $this->hasMany(bill::class , 'provider_id','id');
    }

    public function complaints()
    {
        return $this->hasMany(complaint::class , 'provider_id','id');
    }

    public function requests()
    {
        return $this->hasMany(user_req::class , 'provider_id','id');
    }
    public function offers()
    {
        return $this->hasMany(offer::class , 'provider_id','id');
    }
    public function employes()
    {
        return $this->hasMany(employe::class , 'provider_id','id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
