<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client extends Model
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
        'client_name',
        'address',
        'counter',
        'phone',
        'id_photo',
        'box_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
    public function provider()
    {
        return $this->belongsTo(provider::class , 'provider_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($client) {
            // سيتم تعيين قيمة `counter` إلى `id` بعد حفظ السجل
            $client->counter = $client->id;
            $client->save();
        });
    }



}
