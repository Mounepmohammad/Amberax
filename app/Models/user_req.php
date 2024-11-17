<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_req extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'provider_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
    public function provider()
    {
        return $this->belongsTo(provider::class , 'provider_id','id');
    }
}
