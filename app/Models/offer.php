<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offer extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'title',
        'cost_pk',
        'days',
    ];

    public function provider()
    {
        return $this->belongsTo(provider::class , 'provider_id','id');
    }
}
