<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complaint_response extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'complaint_id',
        'comp_response',

    ];

    public function complaint()
    {
        return $this->belongsTo(complaint::class , 'complaint_id' , 'id');
    }
}
