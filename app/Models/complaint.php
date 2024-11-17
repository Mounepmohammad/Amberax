<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complaint extends Model
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
        'descreption',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
    public function provider()
    {
        return $this->belongsTo(provider::class , 'provider_id','id');
    }
    public function responses()
    {
        return $this->hasMany(complaint_response::class , 'complaint_id','id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($complaint) {
            $complaint->responses()->delete();
        });
    }
}
